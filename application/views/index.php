<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dreamz CRUD Test | Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet"> -->
</head>

<body >
    <div class="card text-center">
      <div class="card-header m-2">
         List of Student Record
      </div>
      <div class="card-body">
        <?php 
        if (!empty($this->session->flashdata('create')) )
        { ?>
          <div class="col-sm-12">
              <div class="alert alert-success" id="alert_msg">
                  <?php echo $this->session->flashdata('create');?>
              </div>
          </div>
        <?php
        }

        if (!empty($this->session->flashdata('edit')) )
        { ?>
          <div class="col-sm-12">
              <div class="alert alert-success" id="alert_msg">
                  <?php echo $this->session->flashdata('edit');?>
              </div>
          </div>
        <?php
        }

        if (!empty($this->session->flashdata('exists')) )
        { ?>
          <div class="col-sm-12">
              <div class="alert alert-warning" id="alert_msg">
                  <?php echo $this->session->flashdata('exists');?>
              </div>
          </div>
        <?php
        }
        ?>
        <button type="button" class="btn btn-info btn-sm mb-3" style="float: right;" data-bs-toggle="modal" data-bs-target="#add">Add Student Info</button>

        <table class="table table-hover">
            <thead>
                <tr>
                  <th scope="col">Sr.No</th>
                  <th scope="col">Student Number</th>
                  <th scope="col">Student Name</th>
                  <th scope="col">Date of Birth</th>
                  <th scope="col">Date of Join</th>
                  <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($students_list)) 
                {
                    $i= 1+$this->uri->segment(2);
                    foreach ($students_list as $li) 
                    {
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $li['student_nos']; ?></td>
                            <td><?php echo $li['student_name']; ?></td>
                            <td><?php echo date("d M Y", strtotime($li['student_dob'])); ?></td>
                            <td><?php echo date("d-m-Y", strtotime($li['student_doj'])); ?></td>
                            <td>
                                <!-- Edit  -->
                                <button type="button" class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#edit_<?php echo $li['uid']; ?>">Edit</button>

                                <!-- Delete -->
                                <a onclick="return confirm('Do you really wants to delete ?')" class="btn btn-danger btn-sm mb-3" href="<?php echo base_url('delete_student/'.$li['uid']); ?>">Delete</a> 
                            </td>
                        </tr>

                        <!-- Edit Modal Start -->
                        <div class="modal fade" id="edit_<?php echo $li['uid']; ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
                            <!-- <div class="modal-dialog"> -->
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editLabel">Edit Student Details</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="<?php echo base_url().'update_student/'.$li['uid']; ?>" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="col-md-12">
                                                    <label class="form-label">Student Number</label>
                                                    <input type="number" min="1" class="form-control" id="student_nos" name="student_nos" value="<?php echo $li['student_nos']; ?>" required placeholder="Enter Student Number">
                                                </div><br>
                                                <div class="col-md-12">
                                                    <label class="form-label">Student Name</label>
                                                    <input type="text" class="form-control" name="student_name" id="student_name" value="<?php echo $li['student_name']; ?>" required placeholder="Enter Student Name">
                                                </div><br>
                                                <div class="col-md-12">
                                                    <label class="form-label">Date of Birth</label>
                                                    <input type="date" class="form-control" id="student_dob_<?php echo $li['uid']; ?>" name="student_dob" value="<?php echo date("Y-m-d", strtotime($li['student_dob'])); ?>" required  placeholder="Select Date of Birth">
                                                </div><br>
                                                <div class="col-md-12">
                                                    <label class="form-label">Date of Join</label>
                                                    <input type="date" class="form-control" id="student_doj_<?php echo $li['uid']; ?>" name="student_doj" value="<?php echo date("Y-m-d", strtotime($li['student_doj'])); ?>" required placeholder="Select Date of Join">
                                                </div><br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Modal End -->

                        <script>
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth() + 1;  
                            var yyyy = today.getFullYear();

                            if (dd < 10) {
                               dd = '0' + dd;
                            }

                            if (mm < 10) {
                               mm = '0' + mm;
                            } 
                                
                            today = yyyy + '-' + mm + '-' + dd;
                            document.getElementById("student_dob_<?php echo $li['uid']; ?>").setAttribute("max", today);
                            document.getElementById("student_doj_<?php echo $li['uid']; ?>").setAttribute("max", today);
                        </script>
                        <?php
                    }
                } else
                {
                    ?>
                    <tr>
                        <td colspan="6" style="color: red;">No matching record found</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
         <?php echo $this->pagination->create_links(); ?>
      </div>
      <div class="card-footer text-body-secondary m-2">
        <!-- <b>Dreamz CRUD Test</b> -->
        Dreamz CRUD Test
      </div>
    </div>

    
    <!-- Add Modal Start -->
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <!-- <div class="modal-dialog"> -->
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addLabel">Add Student Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <label class="form-label">Student Number</label>
                            <input type="number" min="1" class="form-control" id="student_nos" name="student_nos" value="" required placeholder="Enter Student Number">
                        </div><br>
                        <div class="col-md-12">
                            <label class="form-label">Student Name</label>
                            <input type="text" class="form-control" name="student_name" id="student_name" value="" required placeholder="Enter Student Name">
                            <!-- onkeypress="return event.charCode != 32" -->
                        </div><br>
                        <div class="col-md-12">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="student_dob" name="student_dob" value="" required  placeholder="Select Date of Birth">
                        </div><br>
                        <div class="col-md-12">
                            <label class="form-label">Date of Join</label>
                            <input type="date" class="form-control" id="student_doj" name="student_doj" value="" required placeholder="Select Date of Join">
                        </div><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_info" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Modal End -->

    
</body>

    <script type="text/javascript">
    const myTimeout = setTimeout(close, 4000);

    function close() 
    {
        document.getElementById("alert_msg").style.display = "none";
    }
    </script>

    <!-- space removal student_name -->
    <script>
        var field = document.querySelector('[name="student_name"]');
        /*field.addEventListener('keypress', function ( event ) {  
           var key = event.keyCode;
            if (key === 32) {
              event.preventDefault();
            }
        });*/
    </script>
    


    <script>
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1;  
        var yyyy = today.getFullYear();

        if (dd < 10) {
           dd = '0' + dd;
        }

        if (mm < 10) {
           mm = '0' + mm;
        } 
            
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("student_dob").setAttribute("max", today);
        document.getElementById("student_doj").setAttribute("max", today);
    </script>

    <!-- jQuery -->
    <script src="<?php echo base_url('assets/js/jquery.min.js') ?>" ></script>
    <!-- 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> 
    -->

    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" ></script>
    <!-- <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js') ?>" ></script> -->
</html>