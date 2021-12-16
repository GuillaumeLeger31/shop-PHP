<ul class="category-container">
    <h2>Filtres:</h2>
    <li class=<?= $selectedCat ? '' : 'cat-active' ?>><a href="/">Tous les articles <span class="small">(<?= count($articles) ?>)</span></a></li>
    <?php foreach ($categories as $catName => $catNum) : ?>
        <li class=<?= $selectedCat ===  $catName ? 'cat-active' : '' ?>><a href="/?cat=<?= $catName ?>"> <?= $catName ?><span class="small">(<?= $catNum ?>)</span> </a></li>
    <?php endforeach; ?>
</ul>