<script>
    var listener = new window.keypress.Listener();

    listener.simple_combo("s", function (params) {
        livewire.emit(saveSale)
    })
    listener.simple_combo("b", function () {
        /** Limpia la caja de texto */
        document.getElementById('cash').value = ''
        /** Pone el cursor en la caja */
        document.getElementById('cash').focus()
    })
    /** Cancelar la venta */
    listener.simple_combo("a", function () {
        var total = parseFloat(document.getElementById('hiddenTotal'))
        if (total > 0) {
            // 0; no vamos a eliminar, cleanCart; nombre del evento y al final el mensaje
            Confirm(0, 'cleanCart', '¿Seguro de eliminar el carrito?')
        } else {
            noty('Agrega productos a la venta')
        }
    })
</script>