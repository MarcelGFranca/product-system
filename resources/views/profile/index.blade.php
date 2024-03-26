<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('All users') }}
		</h2>
	</x-slot>
	<div class="py-12">
		@foreach ($users as $user)
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
				<div class="max-w-xl">
					<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
						{{ $user->name }}
						<x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete Account') }}</x-danger-button>

						<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
							<form method="post" action="{{ route('profile.destroy') }}" class="p-6">
								@csrf
								@method('delete')

								<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
									{{ __('Are you sure you want to delete your account?') }}
								</h2>

								<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
									{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
								</p>

								<div class="mt-6 flex justify-end">
									<x-secondary-button x-on:click="$dispatch('close')">
										{{ __('Cancel') }}
									</x-secondary-button>

									<x-danger-button class="ms-3">
										{{ __('Delete Account') }}
									</x-danger-button>
								</div>
							</form>
						</x-modal>

					</p>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</x-app-layout>
