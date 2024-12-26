@extends('admin/layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 text-right">
        <a class="btn btn-sm btn-info" href="{{ route('trnaslationView') }}">Translation List</a>
    </div>
</div>

<div class="row mt-4 justify-content-center">
    <div class="col-md-8">
        <h4 class="text-center">Add Translations</h4>
        <form id="translationForm" method="POST" action="{{ route('saveTranslations') }}">
            @csrf
            <div class="form-group">
                <label for="key_text" class="text-center">Key Text (English):</label>
                <input type="text" name="key_text" id="key_text" class="form-control col-md-5" placeholder="Enter Key Text" required>
            </div>
            <div id="translationRows">
                <!-- New rows for translations will be appended here -->
            </div>
            
            <div class="form-group">
                <label for="languageSelector">Select Language:</label>
                <div class="input-group">
                    <select id="languageSelector" class="search__box form-control">
                        <option value="">Select Language</option>
                        @foreach(getLanguages() as $language)
                            @if($language->translation_status != null)
                                <option value="{{ $language->code }}">{{ $language->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Save Translations</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('languageSelector').addEventListener('change', function() {
            var selectedLang = this.value;
            var selectedLangName = this.options[this.selectedIndex].text;
            
            // Check if the selected language is already added
            var existingLanguages = document.querySelectorAll('input[name="lang[]"]');
            var alreadySelected = false;
            existingLanguages.forEach(function(input) {
                if (input.value === selectedLang) {
                    alert('Language "' + selectedLangName + '" is already selected.');
                    alreadySelected = true;
                }
            });
            
            if (!alreadySelected && selectedLang) {
                var newRow = document.createElement('div');
                newRow.className = 'form-row mt-2';
                newRow.innerHTML = `
                    <div class="form-group col-md-5">
                        <input type="text" name="translate[]" class="form-control" placeholder="Translation in ${selectedLangName}" required>
                    </div>
                    <div class="form-group col-md-5">
                        <input type="text" class="form-control" value="${selectedLangName}" readonly>
                        <input type="hidden" name="lang[]" value="${selectedLang}">
                    </div>
                    <div class="form-group col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                    </div>
                `;
                document.getElementById('translationRows').appendChild(newRow);

                newRow.querySelector('.remove-row').addEventListener('click', function() {
                    newRow.remove();
                });
            }
        });
    });
</script>
@endsection
