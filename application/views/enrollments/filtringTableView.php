

                                    <table id="enrollments" class="table display " cellspacing="0" >
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($enrollments)) {?>
                                            <?php foreach($enrollments as $enroll){ ?>
                                                <tr id="tr_<?php echo $enroll->id; ?>">
                                                    <td>
                                                        <img width="100px" alt="student image" height="100px" class="pull-left" src="<?php echo !empty($enroll->photo_link) ? $enroll->photo_link : base_url().'assets/img/dummy-image.jpg'; ?>">
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url().'enrollments/edit/'.$enroll->id; ?>"><?php echo $enroll->student_name;?></a>
                                                        <p><?php echo $enroll->phone_numbers; ?></p>
                                                        <p>
                                                        <?php
                                                        switch ($enroll->state){
                                                            case 0:
                                                                echo '<button disabled class="btn btn-sm btn-outline yellow  finished_state_btn state_btn">'.$this->lang->line('enrollments_finished').'</button>';
                                                                break;
                                                            case 1:
                                                                echo '<button disabled class="btn btn-sm btn-outline  green active_state_btn state_btn">'.$this->lang->line('enrollments_active').'</button>';
                                                                break;
                                                            case 2:
                                                                echo '<button disabled class="btn btn-sm btn-outline  default state_btn">'.$this->lang->line('enrollments_reteined').'</button>';
                                                                break;
                                                            case 3:
                                                                echo '<button disabled class="btn btn-sm btn-outline  red state_btn">'.$this->lang->line('enrollments_cancelled').'</buttondisabled>';
                                                                break;
                                                            default:
                                                                echo '<button disabled class="btn btn-sm btn-outline yellow finished_state_btn state_btn">'.$this->lang->line('enrollments_reteined').'</button>';
                                                        }
                                                        ?>
                                                        </p>
                                                    </td>
                                                    <td>

                                                        <p><?php echo $this->lang->line('enrollments_enroll_id');?>: <b><?php echo $enroll->id;?></b></p>
                                                        <p><?php echo $this->lang->line('enrollments_start_date');?>: <b><?php echo date($datepicker_format,strtotime($enroll->start_date));?></b></p>
                                                        <p><?php echo $this->lang->line('enrollments_end_date');?>: <b><?php echo date($datepicker_format,strtotime($enroll->end_date));?></b></p>
                                                        <p><?php echo $this->lang->line('course');?>: <b><?php echo $enroll->course_description;?></b></p>

                                                    </td>
                                                    <td>
                                                        <div class="btn-group pull-right" >
                                                            <a type="button" class="dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-cog"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-right" id="ul_<?php echo $enroll->id; ?>" data-enroll_id="<?php echo $enroll->id; ?>" data-state="<?php echo $enroll->id; ?>">
                                                                <li class="enrollments_change"><a href="#" data-toggle="tooltip" title="" class=""  data-confirm="<?php echo $this->lang->line('are_you_sure_delete');?>">Delete</a></li>
                                                                <li class="change_state_lable" data-state_id="<?php echo $enroll->state; ?>">
                                                                    <a href="#" data-toggle="tooltip" title="" class="">Change State</a>
                                                                </li>
                                                                <li class="enrollment_change_stets" data-state_id="1">
                                                                    <a  href="#" data-toggle="tooltip" title=""> <i class="fa <?php echo $enroll->state == 1 ? 'fa-caret-right' : ''; ?>  pull-left" aria-hidden="true" ></i><?php echo $this->lang->line('enrollments_active'); ?></a>
                                                                </li>
                                                                <li class="enrollment_change_stets" data-state_id="2">
                                                                    <a href="#" data-toggle="tooltip" title=""><i class="fa <?php echo $enroll->state == 2 ? 'fa-caret-right' : ''; ?>  pull-left" aria-hidden="true" ></i><?php echo $this->lang->line('enrollments_reteined'); ?></a>
                                                                </li>
                                                                <li class="enrollment_change_stets" data-state_id="0">

                                                                    <a href="#"><i class="fa <?php echo $enroll->state == 0 ? 'fa-caret-right' : ''; ?> pull-left" aria-hidden="true" ></i><?php echo $this->lang->line('enrollments_finished'); ?></a>

                                                                </li>
                                                                <li class="enrollment_change_stets" data-state_id="3">

                                                                    <a href="#" data-toggle="tooltip" title=""><i class="fa <?php echo $enroll->state == 3 ? 'fa-caret-right' : ''; ?> pull-left" aria-hidden="true" ></i><?php echo $this->lang->line('enrollments_cancelled'); ?></a>

                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } else { ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>


