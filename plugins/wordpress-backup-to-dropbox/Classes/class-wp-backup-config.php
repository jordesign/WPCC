<?php
/**
 * A class with functions the perform a backup of WordPress
 *
 * @copyright Copyright (C) 2011-2012 Michael De Wildt. All rights reserved.
 * @author Michael De Wildt (http://www.mikeyd.com.au/)
 * @license This program is free software; you can redistribute it and/or modify
 *          it under the terms of the GNU General Public License as published by
 *          the Free Software Foundation; either version 2 of the License, or
 *          (at your option) any later version.
 *
 *          This program is distributed in the hope that it will be useful,
 *          but WITHOUT ANY WARRANTY; without even the implied warranty of
 *          MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *          GNU General Public License for more details.
 *
 *          You should have received a copy of the GNU General Public License
 *          along with this program; if not, write to the Free Software
 *          Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA.
 */
class WP_Backup_Config {
	const MAX_HISTORY_ITEMS = 20;

	public static function construct() {
		return new self();
	}

	public function __construct() {
		if (!is_array(get_option('backup-to-dropbox-log'))) {
			add_option('backup-to-dropbox-log', array(), null, 'no');
		}

		if (!is_array(get_option('backup-to-dropbox-history'))) {
			add_option('backup-to-dropbox-history', array(), null, 'no');
		}

		$options = get_option('backup-to-dropbox-options');
		if (!$options) {
			$options = array(
				'dropbox_location' => null,
				'in_progress' => false,
				'store_in_subfolder' => false,
				'total_file_count' => 1500,
			);
			add_option('backup-to-dropbox-options', $options, null, 'no');
		}

		$actions = get_option('backup-to-dropbox-actions');
		if (!$actions) {
			add_option('backup-to-dropbox-actions', array(), null, 'no');
		}

		$files = get_option('backup-to-dropbox-processed-files');
		if (!$files) {
			add_option('backup-to-dropbox-processed-files', array(), null, 'no');
		}
	}

	private function as_array($val) {
		if (is_array($val))
			return $val;
		return array();
	}

	public function get_max_file_size() {
		$memory_limit_string = ini_get('memory_limit');
		$memory_limit = (preg_replace('/\D/', '', $memory_limit_string) * 1048576);

		$suhosin_memory_limit_string = ini_get('suhosin.memory_limit');
		$suhosin_memory_limit = (preg_replace('/\D/', '', $suhosin_memory_limit_string) * 1048576);

		if ($suhosin_memory_limit && $suhosin_memory_limit < $memory_limit) {
			$memory_limit = $suhosin_memory_limit;
		}

		$memory_limit /= 2.5;

		return $memory_limit < Dropbox_Facade::MAX_UPLOAD_SIZE ? $memory_limit : Dropbox_Facade::MAX_UPLOAD_SIZE;
	}

	public static function get_backup_dir() {
		return WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'backups';
	}

	public function set_option($option, $value) {
		$options = $this->as_array(get_option('backup-to-dropbox-options'));
		$options[$option] = $value;
		return $this->set_options($options);
	}

	public function get_option($option) {
		$options = $this->as_array(get_option('backup-to-dropbox-options'));
		return isset($options[$option]) ? $options[$option] : false;
	}

	public function get_log() {
		return $this->as_array(get_option('backup-to-dropbox-log'));
	}

	public function get_actions() {
		return $this->as_array(get_option('backup-to-dropbox-actions'));
	}

	public function get_processed_files() {
		return $this->as_array(get_option('backup-to-dropbox-processed-files'));
	}

	public function add_processed_files($new_files) {
		$files = $this->get_processed_files();
		update_option('backup-to-dropbox-processed-files', array_merge($files, $new_files));
		return $this;
	}

	public function set_time_limit() {
		if (ini_get('safe_mode')) {
			if (ini_get('max_execution_time') != 0) {
				$this->log(__('This php installation is running in safe mode so the time limit cannot be set.', 'wpbtd') . ' ' .
							sprintf(__('Click %s for more information.', 'wpbtd'),
									 '<a href="http://www.mikeyd.com.au/2011/05/24/setting-the-maximum-execution-time-when-php-is-running-in-safe-mode/">' . __('here', 'wpbtd') . '</a>'));
			}
		} else {
			@set_time_limit(0);
		}
		return $this;
	}

	public function set_memory_limit() {
		if (function_exists('memory_get_usage'))
			@ini_set('memory_limit', BACKUP_TO_DROPBOX_MEMORY_LIMIT .'M');

		return (int)rtrim(ini_get('memory_limit'), 'M');
	}

	public function is_scheduled() {
		return wp_get_schedule('execute_instant_drobox_backup') !== false;
	}

	public function set_schedule($day, $time, $frequency) {
		$blog_time = strtotime(date('Y-m-d H', strtotime(current_time('mysql'))) . ':00:00');

		//Grab the date in the blogs timezone
		$date = date('Y-m-d', $blog_time);

		//Check if we need to schedule the backup in the future
		$time_arr = explode(':', $time);
		$current_day = date('D', $blog_time);
		if ($day && ($current_day != $day)) {
			$date = date('Y-m-d', strtotime("next $day"));
		} else if ((int)$time_arr[0] <= (int)date('H', $blog_time)) {
			if ($day) {
				$date = date('Y-m-d', strtotime("+7 days", $blog_time));
			} else {
				$date = date('Y-m-d', strtotime("+1 day", $blog_time));
			}
		}

		$timestamp = wp_next_scheduled('execute_periodic_drobox_backup');
		if ($timestamp) {
			wp_unschedule_event($timestamp, 'execute_periodic_drobox_backup');
		}

		//This will be in the blogs timezone
		$scheduled_time = strtotime($date . ' ' . $time);

		//Convert the selected time to that of the server
		$server_time = strtotime(date('Y-m-d H') . ':00:00') + ($scheduled_time - $blog_time);

		wp_schedule_event($server_time, $frequency, 'execute_periodic_drobox_backup');
		return $this;
	}

	public function get_schedule() {
		$time = wp_next_scheduled('execute_periodic_drobox_backup');
		$frequency = wp_get_schedule('execute_periodic_drobox_backup');
		if ($time && $frequency) {
			//Convert the time to the blogs timezone
			$blog_time = strtotime(date('Y-m-d H', strtotime(current_time('mysql'))) . ':00:00');
			$blog_time += $time - strtotime(date('Y-m-d H') . ':00:00');
			$schedule = array($blog_time, $frequency);
		}
		return $schedule;
	}

	public function set_options($options) {
		static $regex = '/[^A-Za-z0-9-_.@]/';
		$errors = array();
		$error_msg = __('The sub directory must only contain alphanumeric characters.', 'wpbtd');

		foreach ($options as $key => $value) {
			preg_match($regex, $value, $matches);
			if (!empty($matches)) {
				$errors[$key] = array(
					'original' => $value,
					'message' => $error_msg
				);
			}
		}

		if (empty($errors)) {
			$newOptions = array();
			foreach ($options as $key => $value)
				$newOptions[$key] = $value;

			$options = $this->as_array(get_option('backup-to-dropbox-options'));
			foreach ($newOptions as $key => $value) {
				$options[$key] = $newOptions[$key];
			}

			update_option('backup-to-dropbox-options', $options);
		}

		return $errors;
	}

	public function clear_history() {
		update_option('backup-to-dropbox-history', array());
	}

	public function get_history() {
		return $this->as_array(get_option('backup-to-dropbox-history'));
	}

	public function log_finished_time() {
		$history = $this->get_history();
		$history[] = time();

		if (count($history) > self::MAX_HISTORY_ITEMS)
			array_shift($history);

		update_option('backup-to-dropbox-history', $history);
		return $this;
	}

	public function complete() {
		wp_clear_scheduled_hook('monitor_dropbox_backup_hook');
		wp_clear_scheduled_hook('run_dropbox_backup_hook');
		wp_clear_scheduled_hook('execute_instant_drobox_backup');

		update_option('backup-to-dropbox-processed-files', array());

		$this->set_option('in_progress', false);
		$this->set_option('is_running', false);
		$this->log_finished_time();
	}

	public function clear_log() {
		update_option('backup-to-dropbox-log', array());
		return $this;
	}

	public function log_error($msg) {
		return $this->log($msg, null, true);
	}

	public function log($msg, $files = null, $error = false) {
		$log = $this->as_array(get_option('backup-to-dropbox-log'));
		$log[] = array(
			'time' => strtotime(current_time('mysql')),
			'message' => $msg,
			'files' => json_encode($files),
			'error' => $error,
		);
		update_option('backup-to-dropbox-log', $log);
		return $this;
	}
}