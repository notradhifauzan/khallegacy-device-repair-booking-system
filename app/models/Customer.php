<?php
class Customer
{
    public function __construct()
    {
        $this->db = new Database();
    }

    //Login Customer
    public function login($username, $password)
    {
        //finding the user with that username
        $this->db->query('SELECT * FROM pengguna WHERE nama=:nama;');
        $this->db->bind(':nama', $username);
        //single method will return the whole row as object
        //so you can treat $row as an object, and access the password

        $row = $this->db->single();

        $hashed_password = $row->kata_laluan;
        if (password_verify($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }

    // Register new Customer
    public function register($data)
    {
        $this->db->query('INSERT INTO pengguna (nama,emel,telefon,kata_laluan) 
        values (:nama,:emel,:telefon,:kata_laluan);');
        // Bind values
        $this->db->bind(':nama', $data['name']);
        $this->db->bind(':emel', $data['email']);
        $this->db->bind(':telefon', $data['phone']);
        $this->db->bind(':kata_laluan', $data['password']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateCustomerDetails($data)
    {
        $this->db->query('update customers set username = :username, password = :password,address = :address, phone=:phone where id=:id');

        $this->db->bind(':username', $data['username']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':id', $data['Customerid']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getCustomerInformation($username)
    {
        $this->db->query('select * from pengguna where nama=:nama;');
        $this->db->bind(':nama', $username);
        return $this->db->single();
    }

    public function findCustomerById($Customerid)
    {
        $this->db->query('select * from customers where id=:id;');
        $this->db->bind(':id', $Customerid);
        $this->db->execute();

        return $this->db->single();
    }

    public function findCustomerByUsername($username)
    {
        $this->db->query('select * from pengguna where nama =:nama;');
        $this->db->bind(':nama', $username);
        $this->db->execute();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function findCustomerByEmail($email)
    {
        $this->db->query('select * from pengguna where emel =:emel;');
        $this->db->bind(':emel', $email);
        $this->db->execute();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function cancelOrder($orderid)
    {
        $this->db->query('update pesanan set order_status=:order_status where orderid=:orderid;');

        $this->db->bind(':order_status', 'terbatal');
        $this->db->bind(':orderid', $orderid);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function cashPayment($orderid){
        $this->db->query('update pesanan set order_status=:order_status where orderid=:orderid');
        $this->db->bind(':order_status','ambil');
        $this->db->bind(':orderid',$orderid);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function onlinePayment($data){
        $this->db->query('update pesanan set receipt_img=:receipt_img, order_status=:order_status
                            where orderid=:orderid;');
        
        $this->db->bind(':receipt_img',$data['image']);
        $this->db->bind(':order_status','semakan');
        $this->db->bind(':orderid',$data['orderid']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function viewOrder($orderid)
    {
        $this->db->query('select pengguna.nama as custname, pengguna.telefon as custphone,
                            pengguna.emel as custmail,receipt_img,
                            pentadbir.nama as staffname,orderid,phone_brand,phone_model,
                            problem_description,img_address,pesanan.datetime,
                            order_status,order_price,order_remarks
                            from pesanan
                            left join pengguna on pesanan.custid = pengguna.id
                            left join pentadbir on pesanan.adminid = pentadbir.id
                            where orderid = :orderid
                            order by datetime ASC;');

        $this->db->bind(':orderid', $orderid);

        return $this->db->single();
    }

    public function myBookings($userid)
    {
        $this->db->query('select pengguna.nama as custname, pengguna.telefon as custphone,
                            pentadbir.nama as staffname,orderid,phone_brand,phone_model,
                            problem_description,img_address,pesanan.datetime,
                            order_status,order_price,order_remarks
                            from pesanan
                            left join pengguna on pesanan.custid = pengguna.id
                            left join pentadbir on pesanan.adminid = pentadbir.id
                            where pengguna.id = :id
                            order by datetime ASC;');
        $this->db->bind(':id', $userid);

        return $this->db->resultSet();
    }

    public function makeBooking($data, $userid)
    {
        $this->db->query('insert into pesanan(custid,phone_brand,phone_model,
                            problem_description,img_address,order_status)
                            values(:custid,:phone_brand,:phone_model,
                            :problem_description,:img_address,:order_status);');
        $this->db->bind(':custid', $userid);
        $this->db->bind(':phone_brand', $data['brand']);
        $this->db->bind(':phone_model', $data['model']);
        $this->db->bind(':problem_description', $data['description']);
        $this->db->bind(':img_address', $data['image']);
        $this->db->bind(':order_status', 'hantar');

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
