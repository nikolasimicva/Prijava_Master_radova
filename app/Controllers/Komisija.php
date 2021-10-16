<?php

namespace App\Controllers;

use App\Models\BiografijaModel;
use App\Models\KomisijaModel;
use App\Models\ModulModel;
use App\Models\ObrazlozenjeTemeModel;
use App\Models\PrijavaModel;
use App\Models\TemaModel;
use App\Models\UsersModel;
use App\Models\KomentariModel;


class Komisija extends BaseController
{
    protected $user;
    protected $temaModel;
    protected $prijavaModel;
    protected $obrazlozenjeModel;
    protected $komisijaModel;
    protected $modulModel;
    protected $bioModel;
    protected $komentariModel;

    public function __construct()
    {
        $this->user = new UsersModel();
        $this->temaModel = new TemaModel();
        $this->prijavaModel = new PrijavaModel();
        $this->obrazlozenjeModel = new ObrazlozenjeTemeModel();
        $this->bioModel = new BiografijaModel();
        $this->komisijaModel = new KomisijaModel();
        $this->modulModel = new ModulModel();
        $this->komentariModel = new KomentariModel();
    }

    public function home()
    {
        return view('komisija/home');
    }
    public function odluka()
    {
        return view('komisija/odluka');
    }
    public function izbor_studenta()
    {
        return view('komisija/izbor_studenta');
    }

    public function prijava_azuriraj($id)
    {
        // prijava
        $prijavaUpit = $this->prijavaModel->builder()->where('id', $id)
        ->get()->getResultArray()[0];
        $data['prijava'] = $prijavaUpit;
 
        // tema
        $tema_id = $prijavaUpit['id_rad'];
        $temaUpit = $this->temaModel->builder()->where('id',  $tema_id)->get()->getResultArray()[0];
        $mentorId = $temaUpit['id_mentor'];
        $mentorUpit = $this->user->builder()->where('id', $mentorId)->get()->getResultArray()[0];
        $data['mentor'] = $mentorUpit;
        $data['tema'] = $temaUpit;

        $id_student = $temaUpit['id_student'];
        $data['id_student'] = $id_student;

        // komisija
        $komisijaUpit = $this->komisijaModel->builder()->where('id_rad', $tema_id)->get()->getResultArray()[0];
        $data['komisija'] = $komisijaUpit;
        $id_clan2 = $komisijaUpit['id_clan_2'];
        $id_clan3 = $komisijaUpit['id_clan_3'];
 
        $clan2Upit = $this->user->builder()->where('id', $id_clan2)->get()->getResultArray()[0];
        $data['clan2'] = $clan2Upit;
 
        $clan3Upit = $this->user->builder()->where('id', $id_clan3)->get()->getResultArray()[0];
        $data['clan3'] = $clan3Upit;
 
        $query = $this->user->builder()
        ->select('id, username')
        ->join('auth_groups_users', 'auth_groups_users.user_id=users.id')
        ->where('group_id', 200)
        ->orderBy('username')
        ->get();
        $data['mentori'] = $query->getResultArray();
        $komentariUpit = $this->komentariModel->builder()->where('id_rad', $tema_id)->get()->getResultArray();
        $komentari = '';

        foreach( $komentariUpit as $komentar){
            if($komentar['mentor_komentar'] != ''){
             $komentari .= 'Komentar mentora: ';
             $komentari .= $komentar['mentor_komentar'];
             $komentari .= ".\r\n";
            }
            if($komentar['ruk_komentar'] != ''){
             $komentari .= 'Komentar rukovodioca: ';
             $komentari .= $komentar['ruk_komentar'];
             $komentari .= ".\r\n";
            }
            if($komentar['st_sluz_komentar'] != ''){
             $komentari .= 'Komentar sluzbe: ';
             $komentari .= $komentar['st_sluz_komentar'];
             $komentari .= ".\r\n";
            }
        }
        $data['prethodni_komentari'] = $komentari;
        return view('komisija/prijava_azuriraj', $data);
    }

    public function prijava_azuriraj_sacuvaj()
    {
        if ($this->validate([
            'ime' => 'required|min_length[5]',
            'indeks' => 'required|min_length[5]',
            'ipms' => 'required|min_length[5]',
            'izbor' => 'required|min_length[5]',
            'naslov_sr' => 'required|min_length[5]',
            'naslov_en' => 'required|min_length[5]',
            'clan2' => 'required',
            'clan3' => 'required',
            'date' => 'required'
        ])) {
            $tema_id = $this->request->getPost('tema_id');
            $temaUpit = $this->temaModel->builder()->where('id',  $tema_id)->get()->getResultArray()[0];
            $rukRada = $temaUpit['id_mentor'];
            $clan2 = $this->request->getPost('clan2');
            $clan3 = $this->request->getPost('clan3');
            if ($rukRada == $clan2 || $rukRada == $clan3 || $clan2 == $clan3) {
                return redirect()->back()->withInput()->with('message', 'Не можете више пута одабрати истог професора');
            }
 
            $id_student = $this->request->getPost('student_id');
 
            $tema = [
                'id_student' => $id_student,
                'id_mentor' => $rukRada,
                'status' => '6',  
                'deleted_at' => '',
            ];
            $this->temaModel->update($tema_id, $tema);
            $id = $tema_id;
            $izborno_podrucje_master_rada = $this->request->getPost('ipms');
            $modulUpit = $this->modulModel->builder()->where('naziv', $izborno_podrucje_master_rada)->get()->getResultArray()[0];
            $prijava = [
                'id_rad' => $id,
                'ime_prezime' => $this->request->getPost('ime'),
                'indeks' => $this->request->getPost('indeks'),
                'izborno_podrucje_MS' => $this->request->getPost('ipms'),
                'autor' => 'studentska sluzba',
                'ruk_predmet' => $modulUpit['ruk_modula'],
                'naslov' => $this->request->getPost('naslov_sr'),
                'naslov_eng' => $this->request->getPost('naslov_en'),
                'datum' => $this->request->getPost('date'),
            ];
 
            $prijava_id_upit = $this->prijavaModel->builder()->where('id_rad', $id)
                ->get()->getResultArray()[0];
            $prijava_id = $prijava_id_upit['id'];
 
            $this->prijavaModel->update($prijava_id, $prijava);
 
            $komisija = [
                'id_rad' => $id,
                'id_pred_kom' => $rukRada,
                'id_clan_2' => $clan2,
                'id_clan_3' => $clan3,
            ];
            $komisija_id_upit = $this->komisijaModel->builder()->where('id_rad', $id)
                ->get()->getResultArray()[0];
            $komisija_id = $komisija_id_upit['id'];
 
            $this->komisijaModel->update($komisija_id, $komisija);
 
            $komentari = $this->request->getPost('komentari');
   
            $komentar = [
                'id_rad' => $id,
                'mentor_komentar' => '',
                'ruk_komentar' => '',
                'st_sluz_komentar' => $komentari,
            ];
            $this->komentariModel->insert($komentar);
 
            return redirect()->to('komisija/home')->with('message', 'Успешно промењена пријава након одлуке К2 комисије');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function odluka_komisije_potrebne_izmene()
    {
        $id_student =  $this->request->getPost('id_student');
        $obrazlozenje = $this->request->getPost('obrazlozenje');
        $array = array('status !=' => '9', 'id_student =' => $id_student);
        $temaUpit = $this->temaModel->builder()->where($array)->get()->getResultArray()[0];
        $komisijaUpit = $this->komisijaModel->builder()->where('id_rad', $temaUpit['id'])->get()->getResultArray()[0];
       
        $odluka = [
            'id_odluke_kom' => '3',
            'obrazlozenje' => $obrazlozenje,
            'datum'=> date("Y/m/d")
        ];
        $this->komisijaModel->update($komisijaUpit['id'], $odluka);
    }

    public function odluka_komisije_prihvata_se()
    {
        $id_student =  $this->request->getPost('id_student');
        $obrazlozenje = $this->request->getPost('obrazlozenje');
        $array = array('status !=' => '9', 'id_student =' => $id_student);
        $temaUpit = $this->temaModel->builder()->where($array)->get()->getResultArray()[0];
        $komisijaUpit = $this->komisijaModel->builder()->where('id_rad', $temaUpit['id'])->get()->getResultArray()[0];
        $odluka = [
            'id_odluke_kom' => '1',
            'obrazlozenje' => $obrazlozenje,
            'datum'=> date("Y/m/d")
        ];
        $this->komisijaModel->update($komisijaUpit['id'], $odluka);
    }

    public function odluka_komisije_odbija_se()
    {
        $id_student =  $this->request->getPost('id_student');
        $obrazlozenje = $this->request->getPost('obrazlozenje');
        $array = array('status !=' => '9', 'id_student =' => $id_student);
        $temaUpit = $this->temaModel->builder()->where($array)->get()->getResultArray()[0];
        $komisijaUpit = $this->komisijaModel->builder()->where('id_rad', $temaUpit['id'])->get()->getResultArray()[0];
        $odluka = [
            'id_odluke_kom' => '2',
            'obrazlozenje' => $obrazlozenje,
            'datum'=> date("Y/m/d")
        ];
        $this->komisijaModel->update($komisijaUpit['id'], $odluka);
    }
}



   