<?php
require_once 'assets/php/admin-header.php';
?>

    <div class="row">
    <div class="col-lg-12">
            <div class="card my-2 border-warning">
                <div class="card-header bg-warning text-white">
                    <h4 class="m-0">Total Feedback From Users</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="showAllFeedback">
                        <p class="text-center align-self-center lead">Please Wait...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--reply feedback modal-->
    <div class="modal fade" id="showReplyModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <h4 class="modal-title">Reply This Feedback</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" class="px-3" id="feedback-reply-form">
                        <div class="form-group">
                            <textarea name="message" id="message" class="form-control" rows="6" placeholder="Write your here..." required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" new="submit" value="Send Reply" class=" btn btn-primary btn-black" id="feebackReplyBtn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--footer area-->
            </div>
        </div>
    </div>
    
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            
            //fetch all feedback of users ajax request
            fetchAllFeedback();
            function fetchAllFeedback(){
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: { action: 'fetchAllFeedback' },
                    success:function(response){
                        $("#showAllFeedback").html(response);
                        $("table").DataTable({
                            order: [0,'desc']
                        });
                    }
                });
            }

            //get the current row user id and feedback id
            var uid;
            var fid;
            $("body").on("click",".replyFeedbackIcon", function(e){
                uid = $(this).attr('id');
                fid = $(this).attr('fid');  
            });

            //send feedback reply to the user ajax request
            $("#feedbackReplyBtn").click(function(e){
                if($("#feedback-reply-form")[0].checkValidity()){
                    let message = $("message").val();
                    e.preventDefault();
                    $("#feedbackReplyBtn").val('Please wait...');
                    $.ajax({
                        url: 'assets/php/admin-action.php',
                        method: 'post',
                        data: { uid: uid, message: message, fid: fid },
                        success:function(response){
                            $("#feedbackReplyBtn").val('Send Reply');
                            $("#showReplyModal").modal('hide');
                            $("#feedback-reply-form")[0].reset();
                            Swal.fire{
                                'Sent!',
                                'Reply sent successfully to the user!',
                                'success'
                            }
                            fetchAllFeedback();
                        }
                    });
                }
            });

            //check notification
            checkNotification();
            function checkNotification(){
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: { action: 'checkNotification' },
                    success:function(response){
                        $("#checkNotification").html(response);
                    }
                });
            }
        });
    </script>
</body>
</html>