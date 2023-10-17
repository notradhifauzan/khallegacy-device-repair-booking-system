<?php
class Customers extends Controller
{
    public function __construct()
    {
        if (isset($_SESSION['valid_actor'])) {
            if ($_SESSION['valid_actor'] != 'customer') {
                redirect('customers/login');
            }
        }
        //unset current controller
        if (isset($_SESSION['current_controller'])) {
            unset($_SESSION['current_controller']);
        }
        $_SESSION['current_controller'] = 'Customers';

        //unset current actor if exist
        if (isset($_SESSION['current_actor'])) {
            unset($_SESSION['current_actor']);
        }

        //set current actor to customer
        $_SESSION['current_actor'] = 'customer';

        //$this->orderModel = $this->model('Order');
        $this->customerModel = $this->model('Customer');
    }

    public function index()
    {
        if (isset($_SESSION['valid_actor'])) {
            unset($_SESSION['valid_actor']);
        }
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

        //load view
        $this->view('customer/register', $data);
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
                    $data['name_err'] = 'Nama pengguna hendaklah mengandungi sekurang-kurangnya satu huruf besar';
                }
                if (!$lowercase) {
                    $data['name_err'] = 'Nama pengguna hendaklah mengandungi sekurang-kurangnya satu huruf kecil';
                }
                if (!$number) {
                    $data['name_err'] = 'Nama pengguna hendaklah mengandungi sekurang-kurangnya satu nombor';
                }
                if ($spaces) {
                    $data['name_err'] = 'Nama pengguna tidak boleh mengandungi sebarang ruang';
                }

                if ($this->customerModel->findCustomerByUsername($data['name'])) {
                    $data['name_err'] = 'Nama pengguna sudah diambil';
                }
            }

            if (empty($data['email'])) {
                $data['email_err'] = "Sila masukkan alamat emel";
            } else {
                if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $data['email_err'] = "Alamat emel tidak sah";
                }

                if ($this->customerModel->findCustomerByEmail($data['email'])) {
                    $data['email_err'] = 'Emel pengguna sudah diambil';
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
                if ($this->customerModel->register($data)) {
                    //redirect to home page
                    flash('customer_register_success', 'Pendaftaran berjaya. Sila log masuk');
                    redirect('customers/login');
                } else {
                    flash('customer_register_failed', 'failed to registers. Something went wrong', 'alert alert-danger');
                    redirect('customers/register');
                }
            } else {
                //Load view with errors
                $this->view('customer/register', $data);
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

            $this->view('customer/register', $data);
        }
    }

    public function cashPayment($orderid){
        if($this->customerModel->cashPayment($orderid)){
            flash('cash_success','Kemaskini berjaya, sila tuntut peranti anda di kedai untuk membuat pembayaran. rujukan: pesanan #'.$orderid);
            redirect('customers/myBookings');
        } else {
            flash('cash_fail','Gagal mengemaskini status pembayaran. Sila cuba lagi','alert alert-danger');
            redirect('customers/myBookings');
        }
    }

    public function onlinePayment($orderid)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fileDestination = '';
            $fileTmpName = '';
            $fileNameNew = '';

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'order' => $this->customerModel->viewOrder($orderid),
                'image' => '',
                'orderid' => $orderid,
                'img_err' => ''
            ];

            //handling image uploads
            if ($_FILES['image']['error'] != 4 || ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] != 0)) {

                $fileName = $_FILES['image']['name'];
                $fileTmpName = $_FILES['image']['tmp_name'];
                $fileSize = $_FILES['image']['size'];
                $fileError = $_FILES['image']['error'];

                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));

                $allowed = array('jpg', 'jpeg', 'png');

                if (!in_array($fileActualExt, $allowed)) {
                    $data['img_err'] = 'Format fail tidak sah. hanya format jpg,jpeg dan png sahaja yang dibenarkan';
                } else {
                    if ($fileError === 0) {
                        if ($fileSize < 1000000) {
                            $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                            $fileDestination = 'img/receipts/' . $fileNameNew;
                            $data['image'] = $fileNameNew;
                        } else {
                            $data['img_err'] = 'Saiz fail terlalu besar';
                        }
                    } else {
                        $data['img_err'] = 'Muat naik fail tidak berjaya';
                    }
                }
            } else {
                $data['img_err'] = 'Sila muat naik resit pembayaran';
            }

            if (empty($data['img_err'])) {
                move_uploaded_file($fileTmpName, $fileDestination);
                if($this->customerModel->onlinePayment($data)){
                    flash('payment_success','Pembayaran anda sedang disemak','alert alert-info');
                    redirect('customers/myBookings');
                } else {
                    //load view with errors
                    flash('payment_fail','Pembayaran tidak berjaya, sila cuba lagi','alert alert-danger');
                    $this->view('customer/bookings/payment',$data);
                }
            } else {
                //load view with errors
                $this->view('customer/bookings/payment', $data);
            }
        } else {
            $data = [
                'order' => $this->customerModel->viewOrder($orderid),
                'img_err' => '',
            ];

            $this->view('customer/bookings/payment', $data);
        }
    }

    public function cancelOrder($orderid)
    {
        if ($this->customerModel->cancelOrder($orderid)) {
            flash('cancel_success', 'Pembatalan pesanan #' . $orderid . ' telah berjaya', 'alert alert-info');
            redirect('customers/myBookings');
        } else {
            flash('cancel_fail', 'Pembatalan tidak berjaya', 'alert alert-danger');
            redirect('customers/myBookings');
        }
    }

    public function myBookings()
    {
        if (!isset($_SESSION['currentUser'])) {
            redirect('customers/login');
        } else {
            if (isset($_SESSION['current_method'])) {
                unset($_SESSION['current_method']);
            }
            $_SESSION['current_method'] = 'pesanan';
            $data = [
                'bookings' => $this->customerModel->myBookings($_SESSION['currentUser']->id),
            ];
            $this->view('customer/bookings/myBookings', $data);
        }
    }

    public function bookings()
    {
        if (isset($_SESSION['current_method'])) {
            unset($_SESSION['current_method']);
        }
        $_SESSION['current_method'] = 'tempahan';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //prepare variables for img uploads
            $fileDestination = '';
            $fileTmpName = '';
            $fileNameNew = '';

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'brand' => trim($_POST['brand']),
                'model' => trim($_POST['model']),
                'description' => trim($_POST['description']),
                'image' => '',

                'brand_err' => '',
                'model_err' => '',
                'description_err' => '',
                'img_err' => '',
            ];

            //handling image uploads
            if ($_FILES['image']['error'] != 4 || ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] != 0)) {

                $fileName = $_FILES['image']['name'];
                $fileTmpName = $_FILES['image']['tmp_name'];
                $fileSize = $_FILES['image']['size'];
                $fileError = $_FILES['image']['error'];

                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));

                $allowed = array('jpg', 'jpeg', 'png');

                if (!in_array($fileActualExt, $allowed)) {
                    $data['img_err'] = 'Format fail tidak sah. hanya format jpg,jpeg dan png sahaja yang dibenarkan';
                } else {
                    if ($fileError === 0) {
                        if ($fileSize < 100000) {
                            $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                            $fileDestination = 'img/uploads/' . $fileNameNew;
                            $data['image'] = $fileNameNew;
                        } else {
                            $data['img_err'] = 'Saiz fail terlalu besar';
                        }
                    } else {
                        $data['img_err'] = 'Muat naik fail tidak berjaya';
                    }
                }
            } else {
                $data['img_err'] = '';
            }

            if (empty($data['brand'])) {
                $data['brand_err'] = 'Sila nyatakan jenama peranti anda';
            }

            if (empty($data['model'])) {
                $data['model_err'] = 'Sila nyatakan model peranti anda';
            }

            if (empty($data['description'])) {
                $data['description_err'] = 'Sila nyatakan masalah berkaitan peranti anda';
            }

            if (empty($data['brand_err']) && empty($data['model_err']) && empty($data['img_err']) && empty($data['description_err'])) {
                //process the data
                move_uploaded_file($fileTmpName, $fileDestination);
                if ($this->customerModel->makeBooking($data, $_SESSION['currentUser']->id)) {
                    flash('order_success', 'pesanan berjaya di hantar!');
                    redirect('customers/myBookings');
                } else {
                    flash('order_fail', 'pesanan gagal di hantar!', 'alert alert-danger');
                    $this->view('customer/bookings/booking_form', $data);
                }
            } else {
                //load view with errors
                $this->view('customer/bookings/booking_form', $data);
            }
        } else {
            //prepares data
            $data = [
                'brand' => '',
                'model' => '',
                'description' => '',

                'brand_err' => '',
                'model_err' => '',
                'description_err' => '',
            ];
            $this->view('customer/bookings/booking_form', $data);
        }
    }

    public function logout()
    {
        unset($_SESSION['currentUser']);
        redirect('customers/login');
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
                //check for customer username
                if ($this->customerModel->findCustomerByUsername($data['name'])) {
                    //user found
                } else {
                    $data['name_err'] = 'Tiada pengguna ditemui dalam pangkalan data';
                }
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Sila masukkan kata laluan';
            }

            //make sure errors are empty
            if (empty($data['username_err']) && empty($data['password_err'])) {
                //validated
                //Check and set logged in user
                $loggedInUser = $this->customerModel->login($data['name'], $data['password']);
                if ($loggedInUser) {
                    $customerObj = $this->customerModel->getCustomerInformation($data['name']);
                    if (isset($_SESSION['currentUser'])) {
                        unset($_SESSION['currentUser']);
                    }
                    //create session
                    $_SESSION['currentUser'] = $customerObj;

                    if (isset($_SESSION['valid_actor'])) {
                        unset($_SESSION['valid_actor']);
                    }
                    $_SESSION['valid_actor'] = 'customer';

                    redirect('customers/home');
                } else {
                    $data['password_err'] = 'Kata laluan salah';
                    $this->view('customer/login', $data);
                }
            } else {
                //Load view with errors
                $this->view('customer/login', $data);
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
            $this->view('customer/login', $data);
        }
    }

    public function home()
    {
        if (isset($_SESSION['current_method'])) {
            unset($_SESSION['current_method']);
        }
        $_SESSION['current_method'] = 'home';

        $data = [
            'customer' => $_SESSION['currentUser'],
        ];
        $this->view('customer/home', $data);
    }
}
