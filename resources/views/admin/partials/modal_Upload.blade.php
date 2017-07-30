<div class="modal fade" id="modal_Upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">File Manager</h4>
      </div>
      <div class="modal-body">
            <iframe src="http://shopproject.com/laravel-filemanager?type=image" frameborder="0"></iframe>
      </div>
    </div>
  </div>
</div>

<style>
    #modal_Upload iframe{
        width:100%;
        height:100%
    }
    #modal_Upload .modal-content{
        height:600px;
    }
    #modal_Upload .modal-body{
        height:500px;
    }
</style>