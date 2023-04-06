<div class="card mt-5">
    <table class="table table-hover table-borderless table-sm" id="table_wh_price">
        <thead>
            <tr>
                <th width="250" class="text-center fw-bold">&ge;</th>
                <th>Harga</th>
                <th width="25">Opsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" class="form-control text-center form-control-sm" name="wh_price[1][qty_min]" placeholder="0"></td>
                <td><input type="text" class="form-control text-end form-control-sm currency numeric" name="wh_price[1][price]" placeholder="0"></td>
                <td class="text-center"><button type="button" class="btn btn-sm text-danger del_price" data-id=""><i class="fa fa-times"></i></button></td>
            </tr>
        </tbody>
    </table>
    <div class="card-footer bg-white">
        <button type="button" id="add_price" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Tambah Harga</button>
    </div>
</div>