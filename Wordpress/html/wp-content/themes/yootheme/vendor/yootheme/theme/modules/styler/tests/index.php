<div id="yo-style-test" class="uk-test uk-animation-fade">
    <?php include(__DIR__."/{$test}.html") ?>
</div>

<script>

    // prevent reload test
    jQuery('#yo-style-test').on('click', 'a[href="#"]', function (e) {
        e.preventDefault();
    });

</script>
