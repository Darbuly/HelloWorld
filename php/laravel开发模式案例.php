<?php 
            //==================王文威  临时开发调试代码 开始======================
            $dev = false;
            if($user->id==273){
                $dev = true;
            }
            //==================王文威  临时开发调试代码 结束======================
            return view('mystore.salesInfo', compact('dev'));




            @if($dev==true)
            {{--                            开发环境--}}
                                        <div class="cont_text_button <?php if ($idx%3==0) echo 'left_item';  else if ($idx%3==1) echo 'center_item'; else echo 'right_item';?>">
                                            <div class="cl-3 fsv-12 data_val">{{$monthData['sales']}}</div>
                                            <div class="cl-3 fsv-12 data_name">销售额(调试中)</div>
                                        </div>
                                    @else
            {{--                            生产环境--}}
                                        <div class="cont_text_button <?php if ($idx%3==0) echo 'left_item';  else if ($idx%3==1) echo 'center_item'; else echo 'right_item';?>">
                                            <div class="cl-3 fsv-12 data_val">{{$monthData['sales']}}</div>
                                            <div class="cl-3 fsv-12 data_name">销售额</div>
                                        </div>
                                    @endif


            
?>