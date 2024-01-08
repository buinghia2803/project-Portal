<div class="modal fade" id="exampleModal-MyLeave" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add leave
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('user.myleave.store') }}" method="POST">
                @method('Post')
                @csrf
                <div class="modal-body">
                    <ul>
                        <li class="row mb-3">
                            <label class="form-label col-4" for="">Registration date:</label>
                            <input class="form-control col-8" type="text" disabled style="width: 250px" name="year"
                                value="{{ date('Y') }}">
                        </li>
                        <li class="row mb-3">
                            <label class="form-label col-4" for="">Reason:</label>
                            <textarea class="form-control col-8" name="note" id="" cols="20" rows="5" style="width: 250px"></textarea>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary"> Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
