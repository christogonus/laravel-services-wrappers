<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Social Media Campaign') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <form method="POST" action="{{ route('generate.store') }}">
                    @csrf

                    <div class="mb-6">
                        <x-input-label value="Number of Sequence" />
                        <x-text-input
                            name="number"
                            type="number" min="1"
                            max="7"
                            value="{{ old('number') }}"
                            class="w-2/5"
                            required
                        />
                        <x-error name="number" />
                    </div>

                    <div class="mb-6">
                        <x-input-label value="Select Campaign Type" />
                        <select name="prompt_id" class="w-2/5" required>
                            <option value="">--SELECT OPTION--</option>
                            @foreach($prompts as $prompt)
                                <option value="{{ $prompt->id }}"> {{ $prompt->name }}</option>
                            @endforeach
                        </select>
                        <x-error name="prompt_id" />
                    </div>

                    <div class="mb-6">
                        <x-input-label value="Enter Niche" />
                        <x-text-input
                            name="niche"
                            type="text"
                            value="{{ old('niche') }}"
                            class="w-2/5"
                            required
                        />
                        <x-error name="niche" />
                    </div>

                    <div class="mb-6">
                        <x-input-label value="Enter product or service" />
                        <x-text-input
                            name="product"
                            type="text"
                            value="{{ old('product') }}"
                            class="w-2/5"
                            required
                        />
                        <x-error name="product" />
                    </div>

                    <div class="mb-6">
                        <x-input-label value="Product Feature" />
                        <textarea name="feature" rows="3" class="w-2/5" required>{{ old('feature') }}</textarea>
                        <x-error name="feature" />
                    </div>

                    <div class="mb-6">
                        <x-input-label value="Image Feature" />
                        <textarea name="feature_image" class="w-2/5" rows="3">{{ old('feature_image') }}</textarea>
                        <x-error name="feature_image" />
                    </div>

                    <div class="mb-6">
                        <x-input-label value="Call To Action" />
                        <textarea name="cta" rows="3" class="w-2/5" required>{{ old('cta') }}</textarea>
                        <x-error name="cta" />
                    </div>

                    <div class="mb-6">
                        <x-input-label value="Discount" />
                        <x-text-input name="discount" type="text" class="w-2/5" value="{{ old('discount') }}" />
                        <x-error name="discount" />
                    </div>

                    <div class="mb-6">
                        <x-input-label value="Event Date" />
                        <x-text-input name="date" type="datetime-local" class="w-2/5" value="{{ old('date') }}"  />
                        <x-error name="date" />
                    </div>

                    <div class="mb-6">
                        <x-input-label value="Offer URL" />
                        <x-text-input name="link" type="text" class="w-2/5" value="{{ old('link') }}" />
                        <x-error name="link" />
                    </div>

                    <div class="mb-6">
                        <x-primary-button>
                            GENERATE CAMPAIGN
                        </x-primary-button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
