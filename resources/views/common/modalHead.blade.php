<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header bg-dark">
              <h5 class="modal-title text-white">
                  {{ $selected_id > 0 ? 'Editar' : 'Crear' }} {{$componentName}}
              </h5>
              <h6 class="text-center text-warning" wire:loading>Por favor espere</h6>
          </div>
          <div class="modal-body">
