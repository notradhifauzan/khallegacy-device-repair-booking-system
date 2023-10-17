<?php
class Admin
{
    public function __construct()
    {
        $this->db = new Database();
    }

    //Login Admin
    public function login($username, $password)
    {
        //finding the user with that username
        $this->db->query('SELECT * FROM pentadbir WHERE nama=:nama;');
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

    // Register new Admin
    public function register($data)
    {
        $this->db->query('INSERT INTO pentadbir (nama,emel,telefon,kata_laluan) 
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

    //methods for handling report page

    public function rowCounter($statement)
    {
        $this->db->query($statement);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getSalesReport($statement)
    {
        $this->db->query($statement);
        //$this->db->execute();
        return $this->db->resultSet();
    }

    //---

    public function updateOrder($data, $orderid, $staffid)
    {
        $this->db->query('update pesanan set adminid=:adminid,order_price=:order_price,
                          order_status=:order_status,order_remarks=:order_remarks
                          where orderid=:orderid');

        $this->db->bind(':adminid', $staffid);
        $this->db->bind(':order_price', $data['price']);
        $this->db->bind(':order_status', $data['order_status']);
        $this->db->bind(':order_remarks', $data['remarks']);
        $this->db->bind(':orderid', $orderid);

        if ($this->db->execute()) {
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

    public function history()
    {
        $this->db->query('select pengguna.nama as custname, pengguna.telefon as custphone,
                            pentadbir.nama as staffname,orderid,phone_brand,phone_model,
                            problem_description,img_address,pesanan.datetime,
                            order_status,order_price,order_remarks
                            from pesanan
                            left join pengguna on pesanan.custid = pengguna.id
                            left join pentadbir on pesanan.adminid = pentadbir.id
                            where order_status = :a
                            order by datetime DESC;');
        $this->db->bind(':a', 'selesai');
        return $this->db->resultSet();
    }

    public function allBookings()
    {
        $this->db->query('select pengguna.nama as custname, pengguna.telefon as custphone,
                            pentadbir.nama as staffname,orderid,phone_brand,phone_model,
                            problem_description,img_address,pesanan.datetime,
                            order_status,order_price,order_remarks
                            from pesanan
                            left join pengguna on pesanan.custid = pengguna.id
                            left join pentadbir on pesanan.adminid = pentadbir.id
                            where order_status not in (:a)
                            order by datetime DESC;');
        $this->db->bind(':a', 'selesai');
        return $this->db->resultSet();
    }

    public function findAdminByEmail($email)
    {
        $this->db->query('select * from pentadbir where emel=:emel');
        $this->db->bind(':emel', $email);
        $this->db->execute();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function updateAdminDetails($data)
    {
        $this->db->query('update pentadbir set nama = :nama, kata_laluan = :kata_laluan,telefon=:telefon where id=:id');

        $this->db->bind(':nama', $data['name']);
        $this->db->bind(':telefon', $data['phone']);
        $this->db->bind(':kata_laluan', $data['password']);
        $this->db->bind(':id', $data['adminid']);
        $this->db->bind(':emel', $data['email']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAdminInformation($username)
    {
        $this->db->query('select * from pentadbir where nama=:nama;');
        $this->db->bind(':nama', $username);
        return $this->db->single();
    }

    public function findAdminById($Adminid)
    {
        $this->db->query('select * from pentadbir where id=:id;');
        $this->db->bind(':id', $Adminid);
        $this->db->execute();

        return $this->db->single();
    }

    public function findAdminByUsername($username)
    {
        $this->db->query('select * from pentadbir where nama =:nama;');
        $this->db->bind(':nama', $username);
        $this->db->execute();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function searchAdmin($query)
    {
        $this->db->query("SELECT * FROM  Admins WHERE
        (name LIKE '%" . $query . "%' OR username LIKE '%" . $query . "%' OR
         address LIKE '%" . $query . "%')");
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getAllAdmin()
    {
        $this->db->query('select * from pentadbir');
        $this->db->execute();
        return $this->db->resultSet();
    }
}
