<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Product</th>
            <th>Sold Qty</th>
            <th>Return Qty</th>
            <th>Price</th>
        </tr>
    </thead>

    <tbody>

    {{-- Accessories --}}
    @foreach($sale->accessories as $item)
    <tr>
        <td>{{ $item->name }}</td>
        <td>{{ $item->available_qty }}</td>

        <td>
            <input type="number"
                class="form-control"
                name="items[{{ $loop->index }}][quantity]"
                max="{{ $item->available_qty }}"
                value="0">
        </td>

        <td>{{ $item->price }}</td>

        <input type="hidden" name="items[{{ $loop->index }}][accessory_id]" value="{{ $item->accessory_id }}">
        <input type="hidden" name="items[{{ $loop->index }}][machinery_id]" value="">
        <input type="hidden" name="items[{{ $loop->index }}][price]" value="{{ $item->price }}">
        <input type="hidden" name="items[{{ $loop->index }}][name]" value="{{ $item->name }}">
    </tr>
    @endforeach


    {{-- Machineries --}}
    @foreach($sale->machineries as $item)
    @php $index = $loop->index + $sale->accessories->count(); @endphp
    <tr>

        <td>{{ $item->name }}</td>
        <td>{{ $item->available_qty }}</td>

        <td>
            <input type="number"
                class="form-control"
                name="items[{{ $index }}][quantity]"
                max="{{ $item->available_qty }}"
                value="0">
        </td>

        <td>{{ $item->price }}</td>

        <input type="hidden" name="items[{{ $index }}][accessory_id]" value="">
        <input type="hidden" name="items[{{ $index }}][machinery_id]" value="{{ $item->machinery_id }}">
        <input type="hidden" name="items[{{ $index }}][price]" value="{{ $item->price }}">
        <input type="hidden" name="items[{{ $index }}][name]" value="{{ $item->name }}">
    </tr>
    @endforeach

    </tbody>
</table>


{{-- Remarks Field --}}
<div class="form-group mt-3">
    <label><strong>Remarks</strong></label>

    <textarea name="remarks"
        class="form-control"
        rows="3"
        placeholder="Write return reason or notes (optional)"></textarea>
</div>