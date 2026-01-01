<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Edit Certificate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Certificate</h2>
        <form action="{{ route('certificate.update', $certificate) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $certificate->id }}">
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $certificate->full_name }}" required>
            </div>
            <div class="mb-3">
                <label for="company_name" class="form-label">Business Unit</label>
                <select class="form-select" id="company_name" name="company_name">
                    <option value="">Select Business Unit</option>
                    @foreach($businessUnits as $unit)
                        <option value="{{ $unit->name }}" {{ $certificate->company_name == $unit->name ? 'selected' : '' }}>
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="qualification" class="form-label">Qualification</label>
                <select class="form-select" id="qualification" name="qualification">
                    <option value="">Select Qualification</option>
                    @foreach($qualifications as $qual)
                        <option value="{{ $qual->name }}" {{ $certificate->qualification == $qual->name ? 'selected' : '' }}>
                            {{ $qual->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="lsp" class="form-label">LSP</label>
                <select class="form-select" id="lsp" name="lsp">
                    <option value="">Select LSP</option>
                    @foreach($lsps as $lspItem)
                        <option value="{{ $lspItem->name }}" {{ $certificate->lsp == $lspItem->name ? 'selected' : '' }}>
                            {{ $lspItem->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="certificate_registration_number" class="form-label">Certificate Registration Number</label>
                <input type="text" class="form-control" id="certificate_registration_number" name="certificate_registration_number" value="{{ $certificate->certificate_registration_number }}" required>
            </div>
            <div class="mb-3">
                <label for="issue_date" class="form-label">Issue Date</label>
                <input type="date" class="form-control" id="issue_date" name="issue_date" value="{{ $certificate->issue_date }}">
            </div>
            <div class="mb-3">
                <label for="expiry_date" class="form-label">Expiry Date</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ $certificate->expiry_date }}">
            </div>
            <div class="mb-3">
                <label for="certificate_file" class="form-label">Certificate File</label>
                <input type="file" class="form-control" id="certificate_file" name="certificate_file">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html> 