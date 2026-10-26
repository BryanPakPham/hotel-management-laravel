
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Vui lòng kiểm tra lại thông tin:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">
            Tên loại phòng <span class="text-danger">*</span>
        </label>
        <input type="text"
               id="name"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $roomType->name ?? '') }}"
               placeholder="Ví dụ: Deluxe"
               maxlength="100"
               required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="base_price" class="form-label">
            Giá cơ bản mỗi đêm (VNĐ) <span class="text-danger">*</span>
        </label>
        <input type="number"
               id="base_price"
               name="base_price"
               class="form-control @error('base_price') is-invalid @enderror"
               value="{{ old('base_price', $roomType->base_price ?? '') }}"
               min="0"
               max="9999999999.99"
               step="0.01"
               required>
        @error('base_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="max_adults" class="form-label">
            Số người lớn tối đa <span class="text-danger">*</span>
        </label>
        <input type="number"
               id="max_adults"
               name="max_adults"
               class="form-control @error('max_adults') is-invalid @enderror"
               value="{{ old('max_adults', $roomType->max_adults ?? 2) }}"
               min="1"
               max="255"
               required>
        @error('max_adults')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="max_children" class="form-label">
            Số trẻ em tối đa
        </label>
        <input type="number"
               id="max_children"
               name="max_children"
               class="form-control @error('max_children') is-invalid @enderror"
               value="{{ old('max_children', $roomType->max_children ?? 0) }}"
               min="0"
               max="255"
               required>
        @error('max_children')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="bed_type" class="form-label">
            Loại giường <span class="text-danger">*</span>
        </label>
        <input type="text"
               id="bed_type"
               name="bed_type"
               class="form-control @error('bed_type') is-invalid @enderror"
               value="{{ old('bed_type', $roomType->bed_type ?? '') }}"
               placeholder="Ví dụ: 1 giường đôi"
               maxlength="100"
               required>
        @error('bed_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="area" class="form-label">
            Diện tích (m²) <span class="text-danger">*</span>
        </label>
        <input type="number"
               id="area"
               name="area"
               class="form-control @error('area') is-invalid @enderror"
               value="{{ old('area', $roomType->area ?? '') }}"
               min="0.01"
               max="9999.99"
               step="0.01"
               required>
        @error('area')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label">
            Mô tả
        </label>
        <textarea id="description"
                  name="description"
                  class="form-control @error('description') is-invalid @enderror"
                  rows="4"
                  placeholder="Mô tả tiện nghi và đặc điểm loại phòng...">{{ old('description', $roomType->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
