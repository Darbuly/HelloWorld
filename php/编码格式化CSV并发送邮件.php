  }
        /**
         *      二、 生成CSV报表文件
         */
        $bom =  chr(0xEF).chr(0xBB).chr(0xBF);
        $header = [$bom.'时间','标题','金额','备注'];//结果集表头
        $disk = Storage::disk('local');
        $tmpFileName = date("YmdHis") . 'withdrawbalances.csv';
        $tmpFileFullPath = storage_path('app') . '/withdraw/' . $tmpFileName;
        $handle = fopen($tmpFileFullPath, "w");
        $i = 0;
        fputcsv($handle, $header);

        foreach ($balances_list as $ymd=>$value){
            foreach ($value as $hi=>$value2){
                foreach ($value2 as $key=>$value3){
                    if($value3['status']==1){//遍历出所有可提现的相关balances
                        $detail = [];
                        if(isset($value3['subItem'])){

                            foreach ($value3['subItem'] as $subItem){

                                switch ($subItem['symbol']){
                                    case 0:
                                        $detail[]  =  $subItem['title'].': +'.$subItem['money'];
                                        break;
                                    case 1:

                                        $detail[]  =  $subItem['title'].': -'.$subItem['money'];
                                        break;
                                    case 2:
                                        if(isset($subItem['subItem'])){
                                            foreach ($subItem['subItem']as $__item){
                                                switch ($__item['symbol']) {
                                                    case 0:
                                                        $detail[]  =  $__item['title'].': +'.$__item['money'];
                                                        break;
                                                    case 1:

                                                        $detail[]  =  $__item['title'].': -'.$__item['money'];
                                                        break;
                                                }
                                            }
                                        }
                                        break;
                                }

                            }
                        }

                        $money = $value3['symbol']==0?'+'.$value3['money']:'-'.$value3['money'];
                        $rows = [
                            mb_convert_encoding($ymd.' '.$hi, 'UTF-8', "auto"),//时间
                            mb_convert_encoding($value3['title'], 'UTF-8', "auto"),//标题
                            mb_convert_encoding($money, 'UTF-8', "auto"),//金额
                            mb_convert_encoding(implode(',',$detail), 'UTF-8', "auto") //详情
                        ];
                        $i++;
                        fputcsv($handle, $rows);
                    }
                }
            }
        }
        fclose($handle);//关闭文件
        /**
         *      三、发送提现邮件
         */
        //发送给街易财务邮箱
        if ($i > 0) {//如果有数据，则发送邮件，没数据则不发邮件
            $text = '提现人：'.$user_name.",".
                '申请时间：'.date("Y-m-d H:i:s").",".
                '提现金额：'.$withdraw_money.",".
                '姓名：'.$bankcard->user_name.",".
                '开户行：'.$bankcard->bank_name.",".
                '银行卡号：'.$bankcard->card_number;
            if($user_id==273){
                $Ret = Mail::raw($text, function ($message) use ($tmpFileFullPath,$user_name) {
                    $message->subject(mb_convert_encoding(date("Y-m-d H:i:s") . "  用户发起了提现申请", 'UTF-8', "auto"))
                        ->to('970073804@qq.com');
                    //在邮件中上传附件
                    $message->attach($tmpFileFullPath, ['as' => mb_convert_encoding(date("Y-m-d H_i_s") . "提现申请相关账单.csv", 'UTF-8', "auto")]);
                });
            }else{
                $Ret = Mail::raw($text, function ($message) use ($tmpFileFullPath,$user_name) {
                    $message->subject(mb_convert_encoding(date("Y-m-d H:i:s") . "  用户发起了提现申请", 'UTF-8', "auto"))
                        ->to('18190775020@189.cn');
                    //在邮件中上传附件
                    $message->attach($tmpFileFullPath, ['as' => mb_convert_encoding(date("Y-m-d H_i_s") . "提现申请相关账单.csv", 'UTF-8', "auto")]);
                });
            }
