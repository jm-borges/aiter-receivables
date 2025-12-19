  @if (session('error'))
      <div class="mb-4 rounded-md bg-red-50 p-4">
          <p class="text-sm text-red-800">{{ session('error') }}</p>
      </div>
  @endif
