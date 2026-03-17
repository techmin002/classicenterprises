<div class="modal fade" id="saleReturnModal" tabindex="-1" role="dialog">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content shadow">

            <div class="modal-header bg-info text-white">

                <h4 class="modal-title">
                    <i class="fa fa-undo"></i>
                    Create Sales Return
                </h4>

                <button type="button" class="close" data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <form method="POST" action="{{ route('sale-returns.store') }}">

                @csrf

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-4">

                            <label>Select Sale Invoice</label>

                            <select name="sale_id" class="form-control" id="saleSelect">

                                <option value="">Select Sale</option>

                                @foreach ($sales as $sale)
                                    <option value="{{ $sale->id }}">

                                        {{ $sale->invoice_number }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                    </div>

                    <hr>

                    <div id="saleItems">

                        <!-- Sale items load here with ajax -->

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-success">

                        <i class="fa fa-save"></i>
                        Submit Return

                    </button>

                    <button type="button" class="btn btn-danger" data-dismiss="modal">

                        Cancel

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
<script>
$(document).ready(function(){

    $('#saleSelect').on('change', function(){

        let sale_id = $(this).val();

        if(sale_id){

            let url = "{{ route('get.sale.items', ':id') }}";
            url = url.replace(':id', sale_id);

            $.ajax({
                url: url,
                type: "GET",
                success: function(data){

                    $('#saleItems').html(data);

                },
                error: function(xhr){

                    console.log(xhr.responseText);
                    alert('Failed to load sale items');

                }
            });

        }else{

            $('#saleItems').html('');

        }

    });

});
</script>