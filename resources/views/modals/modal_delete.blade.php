<div class="modal fade right modal-del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-side" role="document">
    <div class="modal-content">
    <form action="#" name="deleteChoose" method="POST">
      {{ csrf_field() }}
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">{{__('Xoá?')}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">{{__('Bạn chắc chắn muốn xoá?')}}</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Huỷ')}}</button>
        <button type="submit" class="btn btn-primary">{{__('Xoá')}}</button>
      </div>
    </div>
    </form>
  </div>
</div>