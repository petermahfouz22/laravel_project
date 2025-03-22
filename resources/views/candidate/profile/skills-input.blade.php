<div class="flex items-center">
    <select name="technology_id" class="mt-1 block w-full border-gray-300 rounded-md">
        @foreach ($technologies as $technology)
            <option value="{{ $technology->id }}">{{ $technology->name }}</option>
        @endforeach
    </select>
</div>