<?php

class MyClass
{
    public $pod;

    public function __construct($pdo,$pod)
    {
        $this->pdo = $pdo;
        $this->pod = $pod;
    }

    public function bsQry()
    {
        return  "SELECT  COUNT(*) AS cnt, s.*, dgs.Pod_NameBg AS DGS, rdg.Pod_NameBg AS RDG, dp.Pod_NameBG AS DP,dgs.DP_ID AS dp_id, r.proveren AS proveren FROM signali AS s
                 INNER JOIN nug.podelenia AS dgs ON dgs.Pod_Id = s.pod_id
                 LEFT JOIN nug.podelenia AS rdg ON rdg.Pod_Id = dgs.Glav_Pod
                 LEFT JOIN nug.podelenia AS dp ON dp.Pod_Id = dgs.DP_ID
                 LEFT JOIN report as r ON s.id = r.signal_id
                 WHERE s.signaldate >= ? AND s.signaldate <= ? ";
    }

    public function gtSgnl()
    {
        $sth = $this->pdo->prepare($this->bsQry()."GROUP BY $this->pod ORDER BY cnt DESC");
        $sth -> execute([$_GET['from'],$_GET['to']]);

        return $sth->fetchAll(PDO::FETCH_CLASS);
    }

//    public function cntSgnl($pod)
//    {
//        $sth = $this->pdo->prepare("SELECT COUNT(*) AS totalcnt FROM (".$this->bsQry().") AS a");
//        //var_dump($sth);die();
//        $sth -> execute([$_GET['from'],$_GET['to']]);
//
//        return $sth->fetchAll(PDO::FETCH_CLASS);
//    }
}