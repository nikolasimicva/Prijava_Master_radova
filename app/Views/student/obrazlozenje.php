<?php
$this->extend('layout');
$this->section('sidebar');
echo view('student/menu');
$this->endSection();

$this->section('content');
?>

<h1 class="mt-4">Образложење</h1>
<br>

<div class="container">
    <form action="<?= route_to('student/obrazlozenje_sacuvaj') ?>" method="post">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <?= view('Myth\Auth\Views\_message_block') ?>
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="ime">Име и презиме студента</label>
                    <input type="text"
                        class="form-control <?php if (session('errors.ime')) : ?>is-invalid<?php endif ?>"
                        name="ime" aria-describedby="ime" placeholder="Име и презиме студента"
                        value="<?= old('ime') ?>">
                </div>
                <br>
                <div class="form-group">
                    <label for="indeks">Број индекса</label>
                    <input type="text"
                        class="form-control <?php if (session('errors.indeks')) : ?>is-invalid<?php endif ?>"
                        name="indeks" aria-describedby="indeks" placeholder="Број индекса"
                        value="<?= old('indeks') ?>">
                </div>
                <br>
                <div class="form-group">
                    <label for="modul">Модул</label>
                    <select
                        class="form-control <?php if (session('errors.modul')) : ?>is-invalid<?php endif ?> mt-3"
                        id="modul" name="modul">
                        <?php foreach ($modul as $m) : ?>
                        <option value="<?= $m['id'] ?>"><?= $m['naziv'] ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <label for="predmet">Предмет</label>
                    <input type="text"
                        class="form-control <?php if (session('errors.predmet')) : ?>is-invalid<?php endif ?>"
                        name="predmet" aria-describedby="predmet" placeholder="Предмет"
                        value="<?= old('predmet') ?>">
                </div>
                <br>
                <div class="form-group">
                    <label for="oblast">Област мастер рада</label>
                    <input type="text"
                        class="form-control <?php if (session('errors.oblast')) : ?>is-invalid<?php endif ?>"
                        name="oblast" aria-describedby="oblast" placeholder="Област мастер рада"
                        value="<?= old('oblast') ?>">
                </div>

                <br>
                <div class="form-group mb-3">
                    <label for="pcmm">Предмет, циљ и методе мастер рада:</label>
                    <textarea type="text" rows="6"
                        class="form-control <?php if (session('errors.pcmm')) : ?>is-invalid<?php endif ?>"
                        name="pcmm" aria-describedby="pcmm"
                        placeholder="Предмет, циљ и методе мастер рада:"
                        value="<?= old('pcmm') ?>"></textarea>
                </div>



            </div>
            <div class="col-sm-6 col-xs-12">

                <div class="form-group">
                    <label for="sorm">Садржај и очекивани резултати мастер рада:</label>
                    <textarea type="text" rows="7"
                        class="form-control <?php if (session('errors.sorm')) : ?>is-invalid<?php endif ?>"
                        name="sorm" aria-describedby="sorm"
                        placeholder="Садржај и очекивани резултати мастер рада:"
                        value="<?= old('sorm') ?>"></textarea>
                </div>
                <br>
                <h3 class="mt-6">Коментари</h3>
                <div class="form-group">
                    <label for="komentari"></label>
                    <textarea type="text" rows="12"
                        class="form-control <?php if (session('errors.komentari')) : ?>is-invalid<?php endif ?>"
                        name="komentari" aria-describedby="komentari" placeholder="Коментари"
                        value="<?= old('komentari') ?>"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Пошаљите образложење</button>
    </form>
</div>
<br>


<?php $this->endSection(); ?>