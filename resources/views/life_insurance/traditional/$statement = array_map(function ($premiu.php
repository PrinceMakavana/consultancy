$statement = array_map(function ($premium_amount, $due_date,$paid_premiums,$paid_premium_dates,$benefit_type,$benefits_amount,$benefit_received_at) { 
                $value['premium_amount'] = $premium_amount;
                $value['due_date'] = $due_date;

                $value['maturity_benefit'] = ($benefit_type == 'maturity_benefit' && $due_date == $benefit_received_at)?$benefits_amount:0;
            
                $value['assured_benefit'] = ($benefit_type == 'assured_benefit' && $due_date == $benefit_received_at) ? $benefits_amount:0;                
                $value['payment_date'] = $paid_premium_dates;
                if ($due_date == $paid_premiums) {
                    $value['status'] = "Paid";
                }else{
                    $value['status'] = 'Pending';
                }
                
                return $value; 
            }, $premium_amount, $due_date,$paid_premiums,$paid_premium_dates,$benefit_type,$benefits_amount,$benefit_received_at);