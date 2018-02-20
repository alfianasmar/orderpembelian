<?php
namespace Model;

use \PDO;

class Model extends Database
{
	private $sql ='';
	public function getAll($table,$orderBy = '',$urutan = 'DESC')
	{
		if ($orderBy != ''){
			$sql = "SELECT * FROM $table ORDER BY $orderBy $urutan";
		}else{
			$sql = "SELECT * FROM $table  ";
		}
		$query = $this->pdo->prepare($sql);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_OBJ);
		return $data;
	}
	public function getAllLimit($table,$orderBy = '',$urutan = 'DESC',$limit=20)
	{
		if ($orderBy != ''){
			$sql = "SELECT * FROM $table ORDER BY $orderBy $urutan LIMIT 0,$limit";
		}else{
			$sql = "SELECT * FROM $table  LIMIT 0,$limit";
		}
		$query = $this->pdo->prepare($sql);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_OBJ);
		return $data;
	}
	public function selectJoin($table1,$table2,$joinVal,$orderBy='',$urutan='DESC')
	{
		$sql = "SELECT * FROM $table1 INNER JOIN $table2 ON $table1.$joinVal=$table2.$joinVal";
		if($orderBy!=''){
			$sql = "SELECT * FROM $table1 INNER JOIN $table2 ON $table1.$joinVal=$table2.$joinVal ORDER BY $orderBy $urutan";
		}
		$query = $this->pdo->prepare($sql);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_OBJ);
		return $data;
	}
	public function lastId($table,$id)
	{
		$sql="SELECT max($id) as maxId FROM $table";
		$q=$this->pdo->prepare($sql);
		$q->execute();
		$res=$q->fetch(PDO::FETCH_OBJ);
		return $res->maxId;
	}
	public function newId($lastid,$kunci,$nol=4)
	{
		$newId = (int) substr($lastid,strlen($kunci));
		$newId++;
		$newId = $kunci.sprintf("%0".$nol."s",$newId);
		return $newId;
	}
	public function getWhere($table,$where=array())
	{
		$sql = "SELECT * FROM $table";
		if(is_array($where)){
			$sql .= ' WHERE ';
			$i = 0;
			foreach ($where as $key => $value) {
				$i++;
				$sql .= $key."='".$value."' ";
				if($i<count($where)) $sql.=" AND ";
			}
		}
		$query = $this->pdo->prepare($sql);
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_OBJ);
		return $data;
	}
	public function getOne($table,$where=array())
	{
		$sql = "SELECT * FROM $table";
		if(is_array($where)){
			$sql .= ' WHERE ';
			$i = 0;
			foreach ($where as $key => $value) {
				$i++;
				$sql .= $key."='".$value."' ";
				if($i<count($where)) $sql.=" AND ";
			}
		}
		$query = $this->pdo->prepare($sql);
		$query->execute();
		$data = $query->fetch(PDO::FETCH_OBJ);
		return $data;
	}
	public function insert($table,$params=array())
	{
		$sql = "INSERT INTO $table (";
		$i=0;
		foreach ($params as $key => $value) {
			$i++;
			$sql.=$key;
			if($i<count($params)) $sql.=",";
		}
		$sql.=") VALUES (";
		$i=0;
		foreach ($params as $key => $value) {
			$i++;
			$sql.="'$value'";
			if($i<count($params)) $sql.=",";
		}
		$sql.=")";
		$query = $this->pdo->prepare($sql);
		$query->execute();
	}
	public function update($table,$data=array(),$where=array())
	{
		$sql="UPDATE $table SET ";
		$i=0;
		foreach ($data as $key => $value) {
			$i++;
			$sql.="$key='$value'";
			if($i<count($data)) $sql.=",";
		}
		$sql.=" WHERE ";
		$i=0;
		foreach ($where as $key => $value) {
			$i++;
			$sql.="$key='$value'";
			if($i<count($where)) $sql.=" AND ";
		}
		$query=$this->pdo->prepare($sql);
		$query->execute();
	}
	public function delete($table,$where=array())
	{
		$sql="DELETE FROM $table WHERE ";
		$i=0;
		foreach ($where as $key => $value) {
			$i++;
			$sql.="$key='$value'";
			if($i<count($where)) $sql.=" AND ";
		}
		$query=$this->pdo->prepare($sql);
		$query->execute();
	}
	public function uploadFoto($kategori,$kode,$jumlah)
	{
		$foto = array();
		for($i=1;$i<=$jumlah;$i++){
			if($_FILES['foto'.$i]['name']!=''){
				$oldNama = $_FILES['foto'.$i]['name'];
				$ext = strtolower(pathinfo($oldNama,PATHINFO_EXTENSION));
				$newNama = $kode."-".$i.".".$ext;
				move_uploaded_file($_FILES['foto'.$i]['tmp_name'],UPLOAD_PATH.$kategori.DS.$newNama);
				array_push($foto,$newNama);
			}
		}
		return implode(',',$foto);
	}
	//Pencarian
	public function cariProperti($judul,$kategori,$harga,$status,$page)
	{
		$limit = 20;
		$limitStart = ($page-1)*$limit;
		$table = 'properti';
		$sqlLimit = " LIMIT $limitStart,$limit";
		$sqlCount = "SELECT COUNT(*)  AS jumlah FROM $table ";
		$sql = "SELECT * FROM $table ";
		if ($judul!='') {
				if ($kategori!='') {
					if ($harga!='') {
						$harga= explode(" ",$harga);
						if ($status!='') {
							$sqlAdd ="WHERE judul LIKE '%$judul%' AND kategori = '$kategori' AND harga$harga[0]$harga[1] AND status='$status' ";
						}else{
							$sqlAdd ="WHERE judul LIKE '%$judul%' AND $kategori = '$kategori' AND harga$harga[0]'$harga[1]'  ";
						}
					}else{
						if ($status!='') {
							$sqlAdd ="WHERE judul LIKE '%$judul%' AND $kategori = '$kategori' AND status='$status' ";
						}else{
							$sqlAdd ="WHERE judul LIKE '%$judul%' AND kategori = '$kategori'  ";
						}
					}
				}else{
					if ($harga!='') {
						$harga= explode(" ",$harga);
						if ($status!='') {
							$sqlAdd ="WHERE judul LIKE '%$judul%'  AND harga$harga[0]$harga[1] AND status='$status' ";
						}else{
							$sqlAdd ="WHERE judul LIKE '%$judul%'  AND harga$harga[0]$harga[1]  ";
						}
					}else{
						if ($status!='') {
							$sqlAdd = "WHERE judul LIKE '%$judul%'  AND status='$status' ";
						}else{
							$sqlAdd ="WHERE judul LIKE '%$judul%'   ";
						}
					}
				}
		}else{
			if ($kategori!='') {
				if ($harga!='') {
					$harga= explode(" ",$harga);
					if ($status!='') {
						$sqlAdd ="WHERE kategori = '$kategori' AND harga$harga[0]$harga[1] AND status='$status' ";
					}else{
						$sqlAdd ="WHERE kategori = '$kategori' AND harga$harga[0]$harga[1]  ";
					}
				}else{
					if ($status!='') {
						$sqlAdd ="WHERE kategori = '$kategori' AND status='$status' ";
					}else{
						$sqlAdd ="WHERE kategori = '$kategori'  ";
					}
				}
			}else{
				if ($harga!='') {
					$harga= explode(" ",$harga);
					if ($status!='') {
						$sqlAdd ="WHERE harga$harga[0]$harga[1] AND status='$status' ";
					}else{
						$sqlAd ="WHERE harga$harga[0]$harga[1]  ";
					}
				}else{
					if ($status!='') {
						$sqlAdd ="WHERE status='$status' ";
					}else{
						$sqlAdd =" ";
					}
				}
			}
		}
		$sql.=$sqlAdd;
		$sql.=$sqlLimit;
		$sqlCount.=$sqlAdd;
		$query = $this->pdo->prepare($sql);
		$queryCount = $this->pdo->prepare($sqlCount);
		$query->execute();
		$queryCount->execute();
		$getJumlah = $queryCount->fetch();
		$data = $query->fetchAll(PDO::FETCH_OBJ);
		return array('data'=>$data,'getJumlah'=>$getJumlah,'limit'=>$limit);
	}
	public function cariFurnitur($judul,$kategori,$harga,$status,$page)
	{
		$limit = 20;
		$limitStart = ($page-1)*$limit;
		$table = 'furnitur';
		$sqlLimit = " LIMIT $limitStart,$limit";
		$sqlCount = "SELECT COUNT(*)  AS jumlah FROM $table ";
		$sql = "SELECT * FROM $table ";
		if ($judul!='') {
				if ($kategori!='') {
					if ($harga!='') {
						$harga= explode(" ",$harga);
						if ($status!='') {
							$sqlAdd ="WHERE judul LIKE '%$judul%' AND kategori = '$kategori' AND harga$harga[0]$harga[1] AND status='$status' ";
						}else{
							$sqlAdd ="WHERE judul LIKE '%$judul%' AND $kategori = '$kategori' AND harga$harga[0]'$harga[1]'  ";
						}
					}else{
						if ($status!='') {
							$sqlAdd ="WHERE judul LIKE '%$judul%' AND $kategori = '$kategori' AND status='$status' ";
						}else{
							$sqlAdd ="WHERE judul LIKE '%$judul%' AND kategori = '$kategori'  ";
						}
					}
				}else{
					if ($harga!='') {
						$harga= explode(" ",$harga);
						if ($status!='') {
							$sqlAdd ="WHERE judul LIKE '%$judul%'  AND harga$harga[0]$harga[1] AND status='$status' ";
						}else{
							$sqlAdd ="WHERE judul LIKE '%$judul%'  AND harga$harga[0]$harga[1]  ";
						}
					}else{
						if ($status!='') {
							$sqlAdd = "WHERE judul LIKE '%$judul%'  AND status='$status' ";
						}else{
							$sqlAdd ="WHERE judul LIKE '%$judul%'   ";
						}
					}
				}
		}else{
			if ($kategori!='') {
				if ($harga!='') {
					$harga= explode(" ",$harga);
					if ($status!='') {
						$sqlAdd ="WHERE kategori = '$kategori' AND harga$harga[0]$harga[1] AND status='$status' ";
					}else{
						$sqlAdd ="WHERE kategori = '$kategori' AND harga$harga[0]$harga[1]  ";
					}
				}else{
					if ($status!='') {
						$sqlAdd ="WHERE kategori = '$kategori' AND status='$status' ";
					}else{
						$sqlAdd ="WHERE kategori = '$kategori'  ";
					}
				}
			}else{
				if ($harga!='') {
					$harga= explode(" ",$harga);
					if ($status!='') {
						$sqlAdd ="WHERE harga$harga[0]$harga[1] AND status='$status' ";
					}else{
						$sqlAd ="WHERE harga$harga[0]$harga[1]  ";
					}
				}else{
					if ($status!='') {
						$sqlAdd ="WHERE status='$status' ";
					}else{
						$sqlAdd =" ";
					}
				}
			}
		}
		$sql.=$sqlAdd;
		$sql.=$sqlLimit;
		$sqlCount.=$sqlAdd;
		$query = $this->pdo->prepare($sql);
		$queryCount = $this->pdo->prepare($sqlCount);
		$query->execute();
		$queryCount->execute();
		$getJumlah = $queryCount->fetch();
		$data = $query->fetchAll(PDO::FETCH_OBJ);
		return array('data'=>$data,'getJumlah'=>$getJumlah,'limit'=>$limit);
	}
}
?>
