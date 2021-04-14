/**
 * Assets helper functions for admin.
 *
 * @since 1.8.0
 * @author Joel James <joel@incsub.com>
 *
 * Beehive, Copyright 2007-2019 Incsub (http://incsub.com).
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

import store from '@/store/store'

/**
 * Get the full image url for admin.
 *
 * @param path Image name.
 *
 * @since 1.8.0
 *
 * @return {string | string}
 */
export function imageUrl(path) {
	const ivtUrl = window.ivtVars.urls.base

	return ivtUrl + 'app/assets/img/' + path
}

/**
 * Get a single option value.
 *
 * @param {string} key Option key.
 * @param {string|boolean|array|integer|object} value Default value.
 *
 * @since 1.8.0
 *
 * @return {string|boolean}
 */
export function getOption(key, value = false) {
	let settings = store.state.settings

	// Only if set.
	if (settings[key]) {
		value = settings[key]
	}

	return value
}

/**
 * Set a single option value.
 *
 * Note: This will not update the value in db.
 * You need to call saveOptions() action for that.
 *
 * @param {string} key Option key.
 * @param {string|boolean|array} value Default value.
 *
 * @since 1.8.0
 *
 * @return {string|boolean}
 */
export function setOption(key, value) {
	store.dispatch('settings/setOption', {
		key: key,
		value: value,
	})
}

/**
 * Check if current member's membership is valid.
 *
 * @since 1.8.0
 *
 * @return {boolean}
 */
export function validMember() {
	return window.ivtVars.membership.valid > 0
}

/**
 * Check if current member's status if expired.
 *
 * @since 1.8.0
 *
 * @return {boolean}
 */
export function expiredMember() {
	return 'expired' === window.ivtVars.membership.status
}

/**
 * Check if Dash plugin is active.
 *
 * @since 1.8.0
 *
 * @return {boolean}
 */
export function dashActive() {
	return window.ivtVars.membership.dash_active > 0
}

/**
 * Check if Dash plugin is installed.
 *
 * @since 1.8.4
 *
 * @return {boolean}
 */
export function dashInstalled() {
	return window.ivtVars.membership.dash_installed > 0
}

/**
 * Check if Dash plugin is connected.
 *
 * @since 1.8.0
 *
 * @return {boolean}
 */
export function dashConnected() {
	return window.ivtVars.membership.dash_connected > 0
}
