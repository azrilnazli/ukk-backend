<button  @if(!empty($tenderSubmission->screening_scoring)) disabled @endif id="submit" class="btn btn-primary" >Submit</button>
<button  type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('signers.tasks') }}'">
    Cancel
</button>

<!-- Script -->
<script>
$( document ).ready(function() {
        $( "#submit" ).click(function(e) {

            //alert( "Handler for .click() called." );
            $('#modal_submit').modal('show');
            e.preventDefault();
            //$("#store_scorings").submit();
        });
        $( "#agree" ).click(function() {
            $("#store_scorings").submit();
            $('#modal_submit').modal('hide');
            //alert( "Handler for .click() called." );
        });
});
</script>
<!-- ./Script -->
<!-- Modal -->
<div class="modal fade" id="modal_submit" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

            <div class="modal-header">
                <h5>Submit Agreement</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Penyerahan maklumat saringan ini adalah MUKTAMAD dan TIDAK BOLEH diubah.</p>
                <p>Sila pastikan ia adalah muktamad dan klik butang SUBMIT untuk penyerahan.</p>
            </div>

            <div class="modal-footer">
                <button id="agree" type="submit" class="btn btn-primary" data-dismiss="modal">SUBMIT</button>
                <button class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
            </div>

      </div>
    </div>
  </div>
