<div class="modal fade ModelCustom" id="viewModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title" id="viewModalTitle"><?php echo "View ".$subMenuLabel['sub_menu']; ?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <table class="table table-bordered scrolling table-sm tableViewModal">
               <tbody id="viewModalContent"></tbody>
            </table>
            <br><div id="other_details" class="table-responsive TblPay"></div>
            <br><div id="other_details1" class="table-responsive TblPay"></div>
         </div>
         <!-- Modal footer -->
<!--
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
-->
      </div>
   </div>
</div>
<div class="clearfix"></div>
<footer class="footer">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12 col-sm-12 col-md-12">
            <span>© Temple Management System</span>
         </div>
      </div>
   </div>
</footer>
</body>
</html>