<span class="inline-block px-3 py-1 rounded-full text-sm {{ $status == 'pending' ? 'bg-yellow-200 text-yellow-800' : ($status == 'accepted' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') }}">
    {{ ucfirst($status) }}
</span>