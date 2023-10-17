<?php
class Admins extends Controller
{
    public function __construct()
    {
        if (isset($_SESSION['valid_actor'])) {
            if ($_SESSION['valid_actor'] != 'admin') {
                redirect('admins/login');
            }
        }
        //unset current controller
        if (isset($_SESSION['current_controller'])) {
            unset($_SESSION['current_controller']);
        }
        $_SESSION['current_controller'] = 'Admins';

        //unset current actor if exist
        if (isset($_SESSION['current_actor'])) {
            unset($_SESSION['current_actor']);
        }

        //set current actor to admin
        $_SESSION['current_actor'] = 'admin';

        //$this->orderModel = $this->model('Order');
        $this->adminModel = $this->model('Admin');
    }

    public function index()
    {
        if (isset($_SESSION['valid_actor'])) {
            unset($_SESSION['valid_actor']);
        }
        //init data
        $data = [
            'username' => '',
            'password' => '',

            'username_err' => '',
            'password_err' => '',
        ];

        //load view
        $this->view('admin/register', $data);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //process the form

            //sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //init data
            $data = [
                'name' => trim($_POST['name']),
                'phone' => trim($_POST['phone']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),

                'name_err' => '',
                'phone_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            //validation

            if (empty($data['name'])) {
                $data['name_err'] = 'Sila masukkan nama';
            } else {
                $uppercase = preg_match('@[A-Z]@', $data['name']);
                $lowercase = preg_match('@[a-z]@', $data['name']);
                $number    = preg_match('@[0-9]@', $data['name']);
                $spaces    = preg_match('/\s/', $data['name']);

                if (!$uppercase) {
                    $data['name_err'] = 'Nama pentadbir hendaklah mengandungi sekurang-kurangnya satu huruf besar';
                }
                if (!$lowercase) {
                    $data['name_err'] = 'Nama pentadbir hendaklah mengandungi sekurang-kurangnya satu huruf kecil';
                }
                if (!$number) {
                    $data['name_err'] = 'Nama pentadbir hendaklah mengandungi sekurang-kurangnya satu nombor';
                }
                if ($spaces) {
                    $data['name_err'] = 'Nama pentadbir tidak boleh mengandungi sebarang ruang';
                }

                if ($this->adminModel->findadminByUsername($data['name'])) {
                    $data['name_err'] = 'Nama pentadbir sudah diambil';
                }
            }

            if (empty($data['email'])) {
                $data['email_err'] = "Sila masukkan alamat emel";
            } else {
                if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $data['email_err'] = "Alamat emel tidak sah";
                }

                if ($this->adminModel->findAdminByEmail($data['email'])) {
                    $data['email_err'] = 'Emel pentadbir sudah diambil';
                }
            }

            if (empty($data['phone'])) {
                $data['phone_err'] = 'Sila masukkan nombor telefon anda';
            } else {
                if (strlen($data['phone']) > 11 || strlen($data['phone']) < 10) {
                    $data['phone_err'] = 'Nombor telefon tidak sah';
                }
                if (!is_numeric($data['phone'])) {
                    $data['phone_err'] = 'Nombor telefon tidak sah';
                }
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Sila masukkan kata laluan';
            } else {
                if (strlen($data['password']) < 6) {
                    $data['password_err'] = 'Kata laluan mestilah sekurang-kurangnya 6 aksara';
                } else {
                    $uppercase = preg_match('@[A-Z]@', $data['password']);
                    $lowercase = preg_match('@[a-z]@', $data['password']);
                    $number    = preg_match('@[0-9]@', $data['password']);
                    $specialChars = preg_match('@[^\w]@', $data['password']);

                    if (!$uppercase) {
                        $data['password_err'] = 'Kata laluan hendaklah mengandungi sekurang-kurangnya satu huruf besar';
                    } else if (!$lowercase) {
                        $data['password_err'] = 'Kata laluan hendaklah mengandungi sekurang-kurangnya satu huruf kecil';
                    } else if (!$number) {
                        $data['password_err'] = 'Kata laluan hendaklah mengandungi sekurang-kurangnya satu nombor';
                    } else if (!$specialChars) {
                        $data['password_err'] = 'Kata laluan hendaklah mengandungi sekurang-kurangnya satu aksara khas';
                    }
                }
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Sila sahkan kata laluan';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Kata laluan tidak sepadan';
                }
            }

            //make sure errors are empty
            if (
                empty($data['username_err']) && empty($data['name_err'])
                && empty($data['password_err']) && empty($data['confirm_password_err'])
                & empty($data['phone_err']) && empty($data['address_err'])
            ) {
                //validated
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register User
                if ($this->adminModel->register($data)) {
                    //redirect to home page
                    flash('admin_register_success', 'Pendaftaran pentadbir berjaya. Sila log masuk');
                    redirect('admins/login');
                } else {
                    flash('admin_register_failed', 'failed to registers. Something went wrong', 'alert alert-danger');
                    redirect('admins/register');
                }
            } else {
                //Load view with errors
                $this->view('admin/register', $data);
            }
        } else {
            //init data
            $data = [
                'name' => '',
                'phone' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',

                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            $this->view('admin/register', $data);
        }
    }

    public function updateOrder($orderid)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'order' => $this->adminModel->viewOrder($orderid),
                'price' => trim($_POST['price']),
                'remarks' => trim($_POST['remarks']),
                'order_status' => trim($_POST['status']),

                'status_err' => ''
            ];

            if (empty($data['order_status'])) {
                $data['status_err'] = 'Sila kemaskini status pesanan';
            }

            if (empty($data['status_err'])) {
                //ready for processing
                if ($this->adminModel->updateOrder($data, $orderid, $_SESSION['currentUser']->id)) {
                    flash('update_success', 'Kemaskini pesanan berjaya untuk pesanan #' . $orderid);
                    redirect('admins/bookings');
                } else {
                    flash('update_fail', 'Kemaskini pesanan tidak berjaya', 'alert alert-danger');
                    $this->view('admin/bookings/viewOrder', $data);
                }
            } else {
                $this->view('admin/bookings/viewOrder', $data);
            }
        } else {
            $data = [
                'order' => $this->adminModel->viewOrder($orderid),
            ];
            $this->view('admin/bookings/viewOrder', $data);
        }
    }

    public function report()
    {
        if (!isset($_SESSION['currentUser'])) {
            redirect('admins/login');
        } else {
            if (isset($_SESSION['current_method'])) {
                unset($_SESSION['current_method']);
            }
            $_SESSION['current_method'] = 'laporan';
            $this->view('admin/bookings/report');
        }
    }

    public function salesReport()
    {
        //will act as AJAX handler
        if (isset($_POST["action"])) {
            if ($_POST["action"] == 'fetch') {
                $order_column = array('order_number', 'order_total', 'order_date');

                $main_query = "
                SELECT orderid as order_number, SUM(order_price) AS order_total, order_date as order_date
                FROM pesanan 
                ";

                $orderStatus = 'selesai';

                $search_query = ' WHERE order_date <= "' . date('Y-m-d') . '" AND order_status = "' . $orderStatus . '" AND ';

                if(isset($_POST['start_date'],$_POST['end_date']) && $_POST['start_date'] != '' && $_POST['end_date'] != ''){
                    $search_query .= ' order_date >= "'.$_POST['start_date'].'" AND order_date <= "'.$_POST['end_date'].'" AND ';
                }

                if (isset($_POST["search"]["value"])) {
                    $search_query .= '(orderid LIKE "%' . $_POST["search"]["value"] . '%" OR order_price LIKE "%' . $_POST["search"]["value"] . '%" OR order_date LIKE "%' . $_POST["search"]["value"] . '%")';
                }

                $group_by_query = " GROUP BY order_date ";

                $order_by_query = "";

                if (isset($_POST["order"])) {
                    $order_by_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
                } else {
                    $order_by_query = 'ORDER BY order_date DESC ';
                }

                $limit_query = '';

                if ($_POST["length"] != -1) {
                    $limit_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
                }

                $statement1 = $main_query . $search_query . $group_by_query . $order_by_query;
                $filtered_rows = $this->adminModel->rowCounter($statement1);

                $statement2 = $main_query . $group_by_query;
                $total_rows = $this->adminModel->rowCounter($statement2);

                $statement = $main_query . $search_query . $group_by_query . $order_by_query . $limit_query;

                $result = $this->adminModel->getSalesReport($statement);

                $data = array();

                foreach ($result as $row) {
                    $sub_array = array();

                    $sub_array[] = $row->order_number;

                    $sub_array[] = $row->order_total;

                    $sub_array[] = $row->order_date;

                    $data[] = $sub_array;
                }

                $output = array(
                    "draw"            =>    intval($_POST["draw"]),
                    "recordsTotal"    =>    $total_rows,
                    "recordsFiltered" =>    $filtered_rows,
                    "data"            =>    $data
                );

                echo json_encode($output);
            }
        }
    }

    public function viewOrder($orderid)
    {
        if (!isset($_SESSION['currentUser'])) {
            redirect('admins/login');
        } else {
            $data = [
                'order' => $this->adminModel->viewOrder($orderid),
            ];
            $this->view('admin/bookings/viewOrder', $data);
        }
    }

    public function history(){
        if (!isset($_SESSION['currentUser'])) {
            redirect('admins/login');
        } else {
            if (isset($_SESSION['current_method'])) {
                unset($_SESSION['current_method']);
            }
            $_SESSION['current_method'] = 'sejarah';
            $data = [
                'bookings' => $this->adminModel->history(),
            ];
            $this->view('admin/bookings/history', $data);
        }
    }

    public function bookings()
    {
        if (!isset($_SESSION['currentUser'])) {
            redirect('admins/login');
        } else {
            if (isset($_SESSION['current_method'])) {
                unset($_SESSION['current_method']);
            }
            $_SESSION['current_method'] = 'tempahan';
            $data = [
                'bookings' => $this->adminModel->allBookings(),
            ];
            $this->view('admin/bookings/allBookings', $data);
        }
    }

    public function logout()
    {
        unset($_SESSION['currentUser']);
        redirect('admins/login');
    }

    public function login()
    {
        if (isset($_SESSION['valid_actor'])) {
            unset($_SESSION['valid_actor']);
        }
        //check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //process the login form
            //sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //init data
            $data = [
                'name' => trim($_POST['name']),
                'password' => trim($_POST['password']),

                'name_err' => '',
                'password_err' => '',
            ];


            if (empty($data['name'])) {
                $data['name_err'] = 'Sila masukkan nama';
            } else {
                //check for admin username
                if ($this->adminModel->findAdminByUsername($data['name'])) {
                    //user found
                } else {
                    $data['name_err'] = 'Tiada nama pentadbir ditemui dalam pangkalan data';
                }
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Sila masukkan kata laluan';
            }

            //make sure errors are empty
            if (empty($data['username_err']) && empty($data['password_err'])) {
                //validated
                //Check and set logged in user
                $loggedInUser = $this->adminModel->login($data['name'], $data['password']);
                if ($loggedInUser) {
                    $adminObj = $this->adminModel->getadminInformation($data['name']);
                    if (isset($_SESSION['currentUser'])) {
                        unset($_SESSION['currentUser']);
                    }
                    //create session
                    $_SESSION['currentUser'] = $adminObj;

                    if (isset($_SESSION['valid_actor'])) {
                        unset($_SESSION['valid_actor']);
                    }
                    $_SESSION['valid_actor'] = 'admin';

                    redirect('admins/home');
                } else {
                    $data['password_err'] = 'Kata laluan salah';
                    $this->view('admin/login', $data);
                }
            } else {
                //Load view with errors
                $this->view('admin/login', $data);
            }
        } else {
            //init data
            $data = [
                'name' => '',
                'password' => '',

                'username_err' => '',
                'password_err' => '',
            ];

            //load view
            $this->view('admin/login', $data);
        }
    }

    public function home()
    {
        $data = [
            'admin' => $_SESSION['currentUser'],
        ];
        $this->view('admin/home', $data);
    }
}
