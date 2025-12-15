  @if (session('success'))
      <div class="mb-4 rounded-md bg-green-50 p-4">
          <p class="text-sm text-green-800">{{ session('success') }}</p>
      </div>
  @endif
