
<h2 class="ml2rem">Article files: <?php echo $_GET["title"];?></h2>

<div class="settings-space">
    <div class="settings-panel">
        <h3>Files uploaded</h3>
        <table class="data journal-tab">
            <tr class="tbl-head">
                <th>FILENAME</th>
                <th>ARTICLE</th>
                <th>DATE SUBMITTED</th>
            </tr>
            <?php echo $files;?>
        </table>
    </div>
</div>
<div class="settings-space">
    <div class="settings-panel">
        <h3>Images uploaded</h3>
        <?php echo $images;?>
    </div>
</div>