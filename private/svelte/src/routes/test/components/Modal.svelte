<script>

    // (Setting the values)
    export let open  = false;
    export let width = 900;

</script>



{ #if open }
    <div class="modal fade show" id="modal-create_room" tabindex="-1" role="dialog" style="display: block;" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: { width }px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <slot name="title" />
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" on:click={ () => { open = false; } }>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <slot name="body" />
                </div>

                <div class="modal-footer">
                    <slot name="footer">
                        <button type="button" class="btn btn-secondary m-auto d-table" data-dismiss="modal" on:click={ () => { open = false; } }>
                            Close
                        </button>
                    </slot>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-backdrop fade show"></div>
{ /if }