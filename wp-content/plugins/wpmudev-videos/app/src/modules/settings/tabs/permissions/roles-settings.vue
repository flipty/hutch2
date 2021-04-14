<template>
	<div class="sui-box-settings-row">
		<div class="sui-box-settings-col-1">
			<h3 class="sui-settings-label">
				{{ $i18n.settings.labels.user_permissions }}
			</h3>
			<p class="sui-description">
				{{ $i18n.settings.descriptions.user_permissions }}
			</p>
		</div>

		<div id="user-permissions" class="sui-box-settings-col-2">
			<h4 id="user-roles-label" class="sui-settings-label">
				{{ $i18n.settings.labels.user_roles }}
			</h4>
			<p class="sui-description">
				{{ $i18n.settings.descriptions.user_roles }}
			</p>
			<div
				role="group"
				class="sui-form-field"
				aria-labelledby="user-roles-label"
			>
				<label
					class="sui-checkbox"
					for="wpmudev-videos-roles-network-administrator"
					v-if="$vars.flags.multisite > 0"
				>
					<input
						type="checkbox"
						disabled="disabled"
						checked="checked"
						id="wpmudev-videos-roles-network-administrator"
						aria-labelledby="wpmudev-videos-roles-network-administrator-label"
					/>
					<span aria-hidden="true"></span>
					<span id="wpmudev-videos-roles-network-administrator-label">
						{{ $i18n.settings.labels.network_administrator }}
					</span>
				</label>

				<label
					class="sui-checkbox"
					for="wpmudev-videos-roles-administrator"
				>
					<input
						type="checkbox"
						disabled="disabled"
						checked="checked"
						id="wpmudev-videos-roles-administrator"
						aria-labelledby="wpmudev-videos-roles-administrator-label"
					/>
					<span aria-hidden="true"></span>
					<span id="wpmudev-videos-roles-administrator-label">
						{{ $i18n.settings.labels.administrator }}
					</span>
				</label>

				<label
					class="sui-checkbox"
					v-for="(label, role) in getRoles"
					:for="`wpmudev-videos-roles-${role}`"
					:key="role"
				>
					<input
						v-model="userRoles"
						type="checkbox"
						:id="`wpmudev-videos-roles-${role}`"
						:aria-labelledby="`wpmudev-videos-roles-${role}-label`"
						:value="role"
					/>
					<span aria-hidden="true"></span>
					<span :id="`wpmudev-videos-roles-${role}-label`">
						{{ label }}
					</span>
				</label>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'RolesSettings',

	computed: {
		/**
		 * User roles option model.
		 *
		 * @since 1.8.0
		 *
		 * @returns {array}
		 */
		userRoles: {
			get() {
				return this.getOption('roles', [])
			},
			set(value) {
				this.setOption('roles', value)
			},
		},

		/**
		 * Get available roles from backend.
		 *
		 * @since 1.8.0
		 *
		 * @returns {array}
		 */
		getRoles() {
			return this.$moduleVars.roles
		},
	},
}
</script>
