@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Create Ebooks</h2>

    <form id="ebooksForm" method="POST" action="{{ route('ebooks.store') }}">
        @csrf
        <div id="ebookSlots"></div>

        <button type="button" id="addSlot" class="btn btn-secondary mt-3">+ Add Slot</button>
        <button type="submit" class="btn btn-primary mt-3">Save All</button>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>

<script>
FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);

let slotCount = 0;

function createSlot() {
    slotCount++;
    let slotId = `slot-${slotCount}`;
    let html = `
        <div class="card p-3 mb-3" id="${slotId}">
            <h5>Ebook Slot ${slotCount}</h5>
            <input type="text" name="ebooks[${slotCount}][title]" placeholder="Title" class="form-control mb-2">
            <textarea name="ebooks[${slotCount}][description]" placeholder="Description" class="form-control mb-2"></textarea>
            <input type="text" name="ebooks[${slotCount}][author]" placeholder="Author" class="form-control mb-2">
            <input type="text" name="ebooks[${slotCount}][category]" placeholder="Category" class="form-control mb-2">
            <input type="text" name="ebooks[${slotCount}][edition]" placeholder="Edition" class="form-control mb-2">
            <input type="text" name="ebooks[${slotCount}][publisher]" placeholder="Publisher" class="form-control mb-2">
            <input type="number" name="ebooks[${slotCount}][copyrightyear]" placeholder="Copyright Year" class="form-control mb-2">
            <input type="text" name="ebooks[${slotCount}][location]" placeholder="Location" class="form-control mb-2">
            <input type="text" name="ebooks[${slotCount}][class]" placeholder="Class" class="form-control mb-2">
            <input type="text" name="ebooks[${slotCount}][subject]" placeholder="Subject" class="form-control mb-2">
            <input type="text" name="ebooks[${slotCount}][doi]" placeholder="DOI" class="form-control mb-2">

            <label>Cover Image</label>
            <input type="file" class="filepond mb-2" name="coverage" data-slot="${slotCount}" data-field="coverage">

            <label>PDF File</label>
            <input type="file" class="filepond mb-2" name="pdf" data-slot="${slotCount}" data-field="pdf">
        </div>
    `;
    document.getElementById('ebookSlots').insertAdjacentHTML('beforeend', html);

    initFilepond(slotId);
}

function initFilepond(slotId) {
    document.querySelectorAll(`#${slotId} input.filepond`).forEach(input => {
        let field = input.dataset.field;
        let slot = input.dataset.slot;

        FilePond.create(input, {
            server: {
                process: {
                    url: "{{ route('file.upload') }}",
                    method: 'POST',
                    withCredentials: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    onload: (res) => {
                        let json = JSON.parse(res);
                        let hidden = document.createElement('input');
                        hidden.type = "hidden";
                        hidden.name = `ebooks[${slot}][${field}]`;
                        hidden.value = json.path;
                        document.querySelector(`#${slotId}`).appendChild(hidden);
                        return json.path;
                    }
                }
            }
        });
    });
}

document.getElementById('addSlot').addEventListener('click', createSlot);

// Create first slot by default
createSlot();
</script>
@endpush
