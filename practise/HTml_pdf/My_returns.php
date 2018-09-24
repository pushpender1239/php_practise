<?php

class My_Returns extends CI_Controller {

    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('plan_model');
        $this->load->model('users_model');
        $this->load->library('email');
        if(!$this->session->userdata('is_logged_in')){
            redirect('user');
        }
    }

    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index($id=0)
    {
        //$this->plan_model->del_plan();

        $idSess = array('pan_idCart'=>$id);
        $this->session->set_userdata('pan_idCart',$idSess);
        $this->session->unset_userdata('tmp_own_plan');
        $user_id = $this->session->userdata('user_id');
        $check_pan = $this->plan_model->check_pan($user_id);
        if($check_pan){
            if($id == 0){

                $user_pan = $this->plan_model->get_user_pan1($user_id);
                $data['user_pan'] = $user_pan;
                $data['check_pan'] = false;
                if($this->session->userdata('cart_summary')){
                      $cart_summary = $this->session->userdata('cart_summary');
                      $pp = $cart_summary['pan'];
                      $year = $this->plan_model->get_year($pp,$user_id);
                }elseif($this->session->userdata('pan_without_session')){
                    $pp = $this->session->userdata('pan_without_session');
                    $year = $this->plan_model->get_year($pp,$user_id);
                }else{
                    foreach($user_pan as $row){
                        $year = $this->plan_model->get_year($row['pan_number'],$user_id);
                        break;
                    }
                }
                $data['year'] = $year;
            }else{

                $data['check_pan'] = true;
                $data['user_pan'] = $this->plan_model->get_user_pan($user_id,$id);
                $pan = $data['user_pan'][0]['pan_number'];
                $data['year'] = $this->plan_model->get_year1($pan,$user_id);
            }

            $data['get_financial_year_plan'] = $this->plan_model->get_financial_year_plan();
            $data['own_plan'] = $this->plan_model->get_own_plan();
            $data['pre_plan'] = $this->plan_model->get_pre_plan();
            //load the view
            $data['main_content'] = 'plan/home';
            //echo "<pre>";print_r($data);die;
            $this->load->view('includes/template', $data);
        }else{
            redirect('my_pan','refresh');
        }

    }
    public function get_return_year(){ //var_dump($this->input->post());exit;
        $user_id = $this->session->userdata('user_id');
        $pan_id = $this->input->post('pan_id');
        $pan = $this->plan_model->get_user_pan($user_id,$pan_id);
        $year = $this->plan_model->get_year($pan[0]['pan_number'],$user_id);//var_dump($year);exit;
        foreach($year as $row){
            if($this->session->userdata('cart_summary')){
                $cart_summary = $this->session->userdata('cart_summary');
                //$aa = $cart_summary["year"];
                $yy = $cart_summary["year"];
            }else{
              if($row == '2015-16'){
                $yy = $row;
              }else{
                $yy = $year;
              }
            // $yy = $year[0]['year_name'];
            }
            ?>
            <option value="<?php echo $row; ?>" <?php if(isset($yy) && $yy == $row){ echo "selected"; } ?>><?php echo $row; ?></option>";
  <?php  }
        if($this->session->userdata('cart_summary')){
            $cart_summary = $this->session->userdata('cart_summary');
            $cart_summary['pan'] = $pan[0]['pan_number'];
            $this->session->unset_userdata('cart_summary');
            $this->session->set_userdata('cart_summary',$cart_summary);
            $this->session->userdata('cart_summary');
        }else{
            $nn = array('pan_without_session' => $pan[0]['pan_number']);
            $this->session->set_userdata($nn);
        }

        //var_dump($this->session->userdata('cart_summary'));
    }
    public function get_pan_number(){
        $id = $this->input->get('pan_id');
        $user_id = $this->session->userdata('user_id');
        $user_pan = $this->plan_model->get_user_pan($user_id,$id);
        echo $user_pan[0]['pan_number'];
    }
    public function change_plan($pname){

        $cart_summary = $this->session->userdata('cart_summary');
        $pls = $this->session->userdata('pan_idCart');
        $pl = $pls['pan_idCart'];
        $pan = $cart_summary['pan'];
        $year = $cart_summary['year'];

        if($cart_summary['plan_flag'] == 0){
            if(count($cart_summary['plan_name']) == 1){
                $this->session->unset_userdata('cart_summary');
                $this->session->unset_userdata('p_id');
            }else{
                $sum1 = 0;$sum =0;
                for($i=0;$i<count($cart_summary['plan_name']);$i++){
                    if($pname != $cart_summary['plan_id'][$i]['plan_id']){
                        $amount = $cart_summary['price'][$i]['amount'];
                        $sum = $sum + $cart_summary['price'][$i]['amount'];
                        $sum1 = (18/100)*$sum;
                        $total = $sum + $sum1;
                        $pids[] = $cart_summary['plan_id'][$i]['plan_id'];
                        $plan_data2[] = array('plan_id' => $cart_summary['plan_id'][$i]['plan_id']);
                        $plan_data1[] = array('plan' => $cart_summary['plan_name'][$i]['plan']);
                        $amount_data[] = array('amount' => $cart_summary['price'][$i]['amount']);
                    }

                }
                //var_dump($pids);
                $p_ids = implode(",",$pids); //var_dump($p_ids);
                $new_data = array('pan' => $pan,'year' => $year,'plan_name' => $plan_data1,'price' => $amount_data,'total' => $total,'plan_flag' => 0,'plan_id' =>$plan_data2);
                $this->session->set_userdata('cart_summary',$new_data);
                //$this->session->set_userdata('p_id',$p_ids);
                $p_id = array('p_id' => $pids);
                $this->session->set_userdata($p_id);
            }
            //echo "<pre>"; var_dump($cart_summary);
        }else{
            $this->session->unset_userdata('cart_summary');
        }
       redirect('my_returns/index/'.$pl.'','refresh');
        //echo "<pre>"; var_dump($this->session->userdata('p_id'));
    }
    public function change_session_year(){
        $year = $this->input->get('year');
        if($this->session->userdata('cart_summary')){
            $this->session->unset_userdata('year_without_session');
            $cart_summary = $this->session->userdata('cart_summary');
            $cart_summary['year'] = $year;
            $this->session->unset_userdata('cart_summary');
            $this->session->set_userdata('cart_summary',$cart_summary);
            $this->session->userdata('cart_summary');
        }else{
            $nn = array('year_without_session' => $year);
            $this->session->set_userdata($nn);
        }
        var_dump($this->session->userdata('cart_summary'));
    }
    public function cart_summary(){
        $pre_plan_id = $this->input->get('pre_plan');
        $own_plan_id = $this->input->get('own_plan');
        $pan = $this->input->get('pan_no');
        $year = $this->input->get('year');
        $own_plan_id1 = explode(",",$own_plan_id);
        $sum = 0;
        $service_tax = '18%';
        echo '<div class="ct-box">
                <h4>Order summary: </h4>
                <h6 id="cart_summary_pan"><b>PAN no: '. strtoupper($pan).'</b></h6>
                <h6><b>Return year: '. $year.'</b></h6>
                <table>
                    <th>Plan</th>
                    <th class="aright">Price(<i class="fa fa-inr" aria-hidden="true"></i>)</th>';
        if($pre_plan_id != ''){
            $sum = 0;
            $result = $this->plan_model->get_amount($pre_plan_id);
            $plan_name = $result[0]['plan_name'];
            $amount = $result[0]['amount']; ?>
             <tr>
                        <td><?php echo $plan_name; ?></td>
                        <td align="right"><?php echo $amount . '.00'; ?></td>
                        <td><input type="button" id="delete" class="btndel" onclick="location.href ='<?php echo base_url(); ?>my_returns/change_plan/<?php echo $pre_plan_id; ?>';"/></td>
                    </tr>
           <?php $sum = (18/100)*$amount;
            $tax = $sum; // need to check here earlier was 15
            $total = $sum + $amount;
            $new_data = array('pan' => $pan,'year' => $year,'plan_name' => $plan_name,'price' => $amount,'total' => $total,'plan_flag' => 1,'plan_id' => $pre_plan_id);
        }else{
            $sum1 = 0;
            $tax=0;
            $total=0;
            for($i=0;$i<count($own_plan_id1);$i++){
                if($own_plan_id1[$i] != ''){
                    $result = $this->plan_model->get_amount($own_plan_id1[$i]);
                    $plan_name = $result[0]['plan_name'];
                    $amount = $result[0]['amount'];
                    $sum = $sum + $result[0]['amount'];
                    $sum1 = (18/100)*$amount;
                    $tax += $sum1;
                    //$total = $sum + $sum1;
                    $total += $amount;
                    $pids[] = $own_plan_id1[$i];
                    $plan_data2[] = array('plan_id' => $own_plan_id1[$i]);
                    $plan_data1[] = array('plan' => $plan_name);
                    $amount_data[] = array('amount' => $amount); ?>
                    <tr>
                            <td><?php echo $plan_name; ?></td>
                            <td align="right"><?php echo $amount . '.00'; ?></td>
                            <td><input type="button" id="delete" class="btndel" onclick="location.href ='<?php echo base_url(); ?>my_returns/change_plan/<?php echo $own_plan_id1[$i]; ?>';" /></td>
                        </tr>
         <?php       }
            }
            $total += $tax;
            $new_data = array('pan' => $pan,'year' => $year,'plan_name' => $plan_data1,'price' => $amount_data,'total' => $total,'plan_flag' => 0,'plan_id' =>$plan_data2);
            $p_id = array('p_id' => $pids);
            $this->session->set_userdata($p_id);
        }
        // echo '<tr> <td>--------------------------</td>
        //                    <td>-----------------------</td>
        //                    </tr>';
        //$tax = (18*$total)/100; // new change here

        echo '<tr>
                <td style="font-weight:bold;">Service Tax(<i class="fa fa-inr" aria-hidden="true"></i>)</td>
                <td align="right">'.$tax.'</td>
            </tr>
            <tr>
                <td style="font-weight:bold;">Total(<i class="fa fa-inr" aria-hidden="true"></i>)</td>
                <td align="right">'.$total.'</td>
            </tr>
        </table>';
        $btn_attributes = array(
                'name' => 'submit',
                // 'content' => 'Proceed now',
                'value' => 'Proceed now',
                'class' => 'btn btn-success',
                'id' => 'submit_plan'
            );
          echo form_submit($btn_attributes);
    echo '</div>';
    $this->session->unset_userdata('pan_without_session');
    $this->session->unset_userdata('year_without_session');
    $this->session->set_userdata('cart_summary',$new_data);
    //var_dump($this->session->userdata('p_id'));
    }
    public function index1($id){
        $this->session->unset_userdata('cart_summary');
        $url = 'my_returns/index/'.$id;
        redirect($url,'refresh');
    }
    public function payment(){
        $service_tax = '18%';
        $sum = 0;//var_dump($this->input->post());exit;
        if(count($this->input->post()) > 4){
            $pre_plan_id = $this->input->post('pre_plan');
            $own_plan_id = $this->input->post('own_plan');
        }else{
            $cart_summary = $this->session->userdata('cart_summary');
             // echo "<pre>";print_r($cart_summary);exit;
            if($cart_summary['plan_flag'] == 0){
                // for($i=0;$i<count($cart_summary['plan_name']);$i++){
                //     $sum = $sum + $cart_summary["price"][$i]["amount"];
                // }
                $own_plan_id1 = $cart_summary['plan_id'];
                for($j=0;$j<count($own_plan_id1);$j++){
                    $own_plan_id[] = $own_plan_id1[$j]['plan_id'];
                }
                $pre_plan_id = '';
            }else{
                $sum = 0;
                $sum = $sum +  $cart_summary["price"];
                $pre_plan_id = $cart_summary['plan_id'];
            }
            $total = $cart_summary["total"];

        }
        if($pre_plan_id != ''){
            $result = $this->plan_model->get_amount($pre_plan_id);
         $amount = $result[0]['amount']; 
          // echo "<pre>"; var_dump($result);exit;
        //echo    $this->db->last_query();die();
            $sum = (18/100)* $amount;
            $total = $sum + $amount;; //$sum+$amount;
            $plan_data[] = array('plan_id' => $pre_plan_id);
        }else{
            $sum = 0;
            for($i=0;$i<@count($own_plan_id);$i++){
                if($own_plan_id[$i] != ''){
                    $result = $this->plan_model->get_amount($own_plan_id[$i]); //var_dump($result);

                    $sum = $sum + $result[0]['amount'];
                    $plan_data[] = array('plan_id' => $own_plan_id[$i]);
                }
            }
            $sum1 = (18/100)*$sum;

            $total = $sum + $sum1;
        } //var_dump($sum1);exit;
        $data['total'] = $total;
        $amount = $total;
        $pan_id = $this->input->post('pan_no');
        $return_year = $this->input->post('year');
        $user_id = $this->session->userdata('user_id');
        @$pan_no = $this->plan_model->GetPanNo($pan_id,$user_id);
        $check_return = $this->plan_model->check_year($return_year,$pan_no,$user_id);
        if($check_return == 0){
        @$this->session->set_userdata('plan_data',$plan_data);
        foreach(@$this->session->userdata('plan_data') as $row){
            $plan[] = implode(",",$row);
        }
        $plan_id = @implode(",",$plan);
        $data = array(
                'user_id' => $user_id,
                'plan_id' => $plan_id,
                'return_year' => '2017-18',
                'pan_no' => strtoupper($pan_no),
                'amount' => $amount,
                'status' => 0,
                'indate' => date('Y-m-d H:i:s')
            ); //echo "<pre>"; var_dump($data);exit;
        $order_id = $this->plan_model->save_order($data);
        $order_ref_no = 'MTR_'.$order_id;
        $data1 = array('order_ref_no' => $order_ref_no);
        $this->plan_model->save_order_ref($data1,$order_id);
        $this->plan_model->update_statuspan($pan_no,$user_id, $pan_id);
       // echo $this->db->last_query();
        $new_data = array(
                'pay_amount' => $amount,
                'pan_id' => $pan_id,
                'return_year' => $return_year
            );
        // print_r($new_data);exit;
        $this->session->set_userdata('pay_data',$new_data);
        $data['address'] = $this->plan_model->get_address($user_id);
        // $uniqid = uniqid();
        // $final_unique = substr($uniqid,0,6);
        $data['order_id'] = $order_ref_no;
        $data['amount'] = $amount;
        $data['main_content'] = 'plan/payment';
       // echo '<pre>';print_r($data);die;
        $cart_summary = $this->session->userdata('cart_summary');
        /*----------function to send mail-----------------------*/ 
       $this->invoice_mail($order_ref_no);
          /*----------function to send mail-----------------------*/ 
        $this->load->view('includes/template', $data);
        }else{
            $this->session->set_flashdata('check_return','Your return have been done for this financial year');
            redirect('my_returns','refresh');
         }
    }

    public function update_order(){ //var_dump($this->input->post());exit;
        $user_id = $this->session->userdata('user_id');
    	$payment_data = array(
    					'order_ref_no' => $this->input->post('order_id'),
    					'tracking_id' => $this->input->post('tracking_id'),
    					'bank_ref_no' => $this->input->post('bank_ref_no'),
    					'order_status' => $this->input->post('order_status'),
    					'failure_message' => $this->input->post('failure_message'),
    					'payment_mode' => $this->input->post('payment_mode'),
    					'card_name' => $this->input->post('card_name'),
    					'status_code' => $this->input->post('status_code'),
    					'status_message' => $this->input->post('status_message'),
    					'currency' => $this->input->post('currency'),
    					'amount' => $this->input->post('amount'),
    					'billing_name' => $this->input->post('billing_name'),
    					'billing_address' => $this->input->post('billing_address'),
    					'billing_city' => $this->input->post('billing_city'),
    					'billing_state' => $this->input->post('billing_state'),
    					'billing_zip' => $this->input->post('billing_zip'),
    					'billing_country' => $this->input->post('billing_country'),
    					'billing_tel' => $this->input->post('billing_tel'),
    					'billing_email' => $this->input->post('billing_email'),
    					'delivery_name' => $this->input->post('delivery_name'),
    					'delivery_address' => $this->input->post('delivery_address'),
    					'delivery_city' => $this->input->post('delivery_city'),
    					'delivery_state' => $this->input->post('delivery_state'),
    					'delivery_zip' => $this->input->post('delivery_zip'),
    					'delivery_country' => $this->input->post('delivery_country'),
    					'delivery_tel' => $this->input->post('delivery_tel'),
    					'merchant_param1' => $this->input->post('merchant_param1'),
    					'merchant_param2' => $this->input->post('merchant_param2'),
    					'merchant_param3' => $this->input->post('merchant_param3'),
    					'merchant_param4' => $this->input->post('merchant_param4'),
    					'merchant_param5' => $this->input->post('merchant_param5'),
    					'vault' => $this->input->post('vault'),
    					'offer_type' => $this->input->post('offer_type'),
    					'offer_code' => $this->input->post('offer_code'),
    					'discount_value' => $this->input->post('discount_value'),
    					'mer_amount' => $this->input->post('mer_amount'),
    					'eci_value' => $this->input->post('eci_value'),
    					'order_ref_no' => $this->input->post('order_id'),
    					'retry' => $this->input->post('retry'),
    					'response_code' => $this->input->post('response_code')
    				);
    	//echo "<pre>"; var_dump($this->input->post());
    	$last_payment = $this->plan_model->save_payment($payment_data);
    	//$last_payment = 1;
    	$order_status = $this->input->post('order_status');
    	if($order_status==="Success"){
			$status = 1;
            $config['protocol'] = 'mail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['mailtype'] = 'html';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $from_email = 'support@mytaxreturns.in';//support@mytaxreturns.in
            $to = $this->session->userdata('email');
            $cname = $this->plan_model->get_user_name($user_id);
            $this->email->initialize($config);
            if($this->session->userdata('cart_summary')){
                $cart_summary = $this->session->userdata('cart_summary');
                $this->generate_pdf($cart_summary,$this->input->post('order_id'));
            }//exit;

            $message = '<html><body><p>Hi, '.$cname.'</p>';
            $message .= '<br />
                        <p style="font-size:15px;font-weight:bold;">Thank you for choosing Mytaxreturns.</p>

<p>You purchase has been successful.  Our Expert will reach out to you shortly. </p>

<p>In the meantime, you can upload some documents on our portal or generate pick up request.  To upload/pick-up request please follow this link  '.base_url().'check_doc/email1/'.$this->input->post("order_id").' and login with your registered ID and password.   </p>
<p>We have also attached an invoice for your purchase. </p>

<p>Need any help? Do not hesitate, please reach us at support@mytaxreturns.in </p>

<p>Best regards,</p>

<p>Mytaxreturns team</p></body></html>
                ';
            $filename = $order_id . '_invoice.pdf';
            $attched_file = base_url()."/assets/pdf/".$filename;
            $subject = 'Your purchase at Mytaxreturns.in';
            $this->email->from($from_email, 'My Tax Returns');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->attach($attched_file);
            $this->email->send();
            //$this->email->print_debugger();
           // $this->send_admin($cname,$to,$this->input->post("order_id"));
                    $this->invoice_mail($this->input->post('order_id'));

            $order_data = array(
                'payment_id' => $last_payment,
                'status' => $status
            );
            $order_id = $this->input->post('order_id'); //var_dump($order_data);exit;
            $this->plan_model->update_order($order_data,$order_id);
            //$this->session->unset_userdata('cart_summary');
            $this->session->set_flashdata('thank_you','Thank you for buying this plan,your ORDER-ID '.$order_id.', either you can upload documents or generate request to pickup documents');
            redirect('documents','refresh');

		}elseif($order_status==="Aborted"){
			$status = 2;
            $order_data = array(
                'payment_id' => $last_payment,
                'status' => $status
          );
        $order_id = $this->input->post('order_id');// var_dump($order_data);exit;
        $this->plan_model->update_order($order_data,$order_id);
            $this->session->set_flashdata('thank_you','Thank you for shopping with us.However,the transaction has been declined.');
        redirect('my_returns/cancel_order','refresh');

		}elseif($order_status==="Failure"){
			$status = 3;
            $order_data = array(
                'payment_id' => $last_payment,
                'status' => $status
          );
        $order_id = $this->input->post('order_id'); //var_dump($order_data);exit;
        $this->plan_model->update_order($order_data,$order_id);
            $this->session->set_flashdata('thank_you','Thank you for shopping with us.However,the transaction has been declined.');
        redirect('my_returns/cancel_order','refresh');
		}else{
			$status = 4;
            $order_data = array(
                'payment_id' => $last_payment,
                'status' => $status
          );
        $order_id = $this->input->post('order_id'); //var_dump($order_data);exit;
        $this->plan_model->update_order($order_data,$order_id);
            $this->session->set_flashdata('thank_you','Thank you for shopping with us.However,the transaction has been declined.');
        redirect('my_returns/cancel_order','refresh');

		}

    }
    public function cancel_order(){
        $data['main_content'] = 'plan/cancel_order';
        $this->load->view('includes/template', $data);
    }
    public function send_admin($cname,$to,$order_ref_no){
        $this->load->model('document_model');
        $config['protocol'] = 'mail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $subject = 'New Package Purchase';
        $from_email = 'support@mytaxreturns.in';//support@mytaxreturns.in
        $to1 = 'neworder@mytaxreturns.in';//neworder@mytaxreturns.in
        $get_order = $this->document_model->get_order_data($order_ref_no);
        $pan_no = $get_order[0]->pan_no;
        $return_year = $get_order[0]->return_year;
        $plan = $get_order[0]->return_year;
        $message = '<html><body><p>Package Purchase:</p>
                <p>NAME: '.$cname.'</p>
                <p>ORDER NUMBER: '.$order_ref_no.'</p>
                <p>Email ID: '.$to.'</p>
                <p>PAN: '.$pan_no.'</p>
                <p>FINANCIAL YEAR: '.$return_year.'</p>';
        if($this->session->userdata('cart_summary')){
            $cart_summary = $this->session->userdata('cart_summary');
            if($cart_summary['plan_flag'] == 0){
                $sum = 0;
                for($i=0;$i<count($cart_summary['plan_name']);$i++){
                    $message .= '<p>PACKAGE: '.$cart_summary["plan_name"][$i]["plan"].'</p>
                <p>Price(Rs.)'.$cart_summary["price"][$i]["amount"].'</p>';
                }
            }else{
                $message .= '<p>PACKAGE: '.$cart_summary["plan_name"].'</p>
                <p>Price(Rs.)'.$cart_summary["price"].'</p>';
            }
            $message .= '</body></html>';
        }
        $this->email->to($to1);
        $this->email->from($from_email, 'My Tax Returns');
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
        $this->session->unset_userdata('cart_summary');
       // echo $this->email->print_debugger();
    }

    public function generate_pdf($cart_summary,$order_ref_no){
    	// print_r($cart_summary);exit;
        $filename = $order_ref_no . '_invoice';
        //this data will be passed on to the view
        $data['the_content'] = $cart_summary;
        // $data['orderID'] = $order_ref_no;
        //load the view, pass the variable and do not show it but "save" the output into $html variable
        $html = $this->load->view('pdf_output', $data, true);
        //this the the PDF filename that user will get to download
        $pdfFilePath = "the_pdf_output.pdf";
        $this->load->library('m_pdf');
        //actually, you can pass mPDF parameter on this load() function
        $pdf = $this->m_pdf->load();
        //generate the PDF!
        $pdf->WriteHTML($html);
        file_put_contents('/assets/pdf/'.$filename.".pdf",$pdf->Output($pdfFilePath, "S"));
    }


    public function invoice_mail($order_id){ 
            $user_id = $this->session->userdata('user_id');
            $status = 1;
            $config['protocol'] = 'mail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['smtp_port'] = 25;
            $config['mailtype'] = 'html';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $from_email = 'support@mytaxreturns.in';//support@mytaxreturns.in
            $to = $this->session->userdata('email');
            $cname = $this->plan_model->get_user_name($user_id);
            $this->email->initialize($config);
            if($this->session->userdata('cart_summary')){
                $cart_summary = $this->session->userdata('cart_summary');
                $this->generate_pdf_invoice($cart_summary,$order_id);
            }//exit;

            $message = '<html><body><p>Hi, '.$cname.'</p>';
            $message .= '<br />
                        <p style="font-size:15px;font-weight:bold;">Thank you for choosing Mytaxreturns.</p>

<p>You purchase has been successful.  Our Expert will reach out to you shortly. </p>

<p>In the meantime, you can upload some documents on our portal or generate pick up request.  To upload/pick-up request please follow this link  '.base_url().'check_doc/email1/'.$order_id.' and login with your registered ID and password.   </p>
<p>We have also attached an invoice for your purchase. </p>

<p>Need any help? Do not hesitate, please reach us at support@mytaxreturns.in </p>

<p>Best regards,</p>

<p>Mytaxreturns team</p></body></html>
                ';
            $filename = $order_id.'_invoice.pdf';
            $attched_file = base_url()."assets/pdf/".$filename;
            $subject = 'Your purchase at Mytaxreturns.in';
            $this->email->from($from_email, 'My Tax Returns');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->attach($attched_file);
            $this->email->send();
    }

    public function generate_pdf_invoice($cart_summary,$order_ref_no){
        // print_r($cart_summary);exit;
        $filename = $order_ref_no . '_invoice';
        //this data will be passed on to the view
        $user_id = $this->session->userdata('user_id');
        $data['user_details'] = $this->db->get_where('users', array('id'=>$user_id,'status'=>0))->row_array();
        $data['the_content'] = $cart_summary;
        $data['orderID'] = $order_ref_no;
        //load the view, pass the variable and do not show it but "save" the output into $html variable
        $html = $this->load->view('invoice', $data, true);
        //this the the PDF filename that user will get to download
        $pdfFilePath = "the_pdf_output.pdf";
        $this->load->library('m_pdf');
        //actually, you can pass mPDF parameter on this load() function
        $pdf = $this->m_pdf->load();
        //generate the PDF!
        $pdf->WriteHTML($html);
        file_put_contents('/var/www/html/test/assets/pdf/'.$filename.".pdf",$pdf->Output($pdfFilePath, "S"));
    }
}
