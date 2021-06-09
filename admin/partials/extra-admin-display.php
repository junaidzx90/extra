<?php
require_once EXTRA_PATH.'admin/class-extra-admin.php';
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Extra
 * @subpackage Extra/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="extra_fields">
<h3>Extra Fields</h3>
<hr>
<div class="contents_area">
    <?php
    if(isset($_POST['save_fields'])){
        if(isset($_POST['extra_numar_comanda']) || isset($_POST['extra_euro'] ) || isset($_POST['extra_valoare_tva'])){
            $this->extra_numar_comanda($_POST['extra_numar_comanda']);
            $this->extra_valoare_tva($_POST['extra_valoare_tva']);
        }
    }
    ?>
    <form action="" method="post">
        <table id="extra_table">
            <tbody>
                <?php
                    global $wpdb;
                    $datas = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}extra_v1");
                    $eur = $wpdb->get_var("SELECT extra_euro FROM {$wpdb->prefix}extra_v1");

                    if($datas){
                        $numar_comanda = '';
                        $extra_euro = '';
                        $valoare_tva = '';

                        foreach($datas as $data){
                            $numar_comanda = $data->numar_comanda;
                            $extra_euro = $data->extra_euro;
                            $valoare_tva = $data->valoare_tva;
                        }
                    }
                ?>
                
                <tr>
                    <th><label for="extra_numar_comanda">Numar comanda</label></th>
                    <td><input type="number" name="extra_numar_comanda" id="extra_numar_comanda" value="<?php echo $numar_comanda; ?>" placeholder="Numar comanda"></td>
                </tr>
                <tr>
                    <th><label for="extra_euro">Curs Euro</label></th>
                    <td><input readonly type="number" name="extra_euro" id="extra_euro" value="<?php echo $eur; ?>" placeholder="Curs Euro"></td>
                </tr>
                <tr>
                    <th><label for="extra_valoare_tva">Valoare TVA</label></th>
                    <td><input type="number" name="extra_valoare_tva" id="extra_valoare_tva" value="<?php echo $valoare_tva; ?>" placeholder="Valoare TVA"></td>
                </tr>
            </tbody>
        </table>

    <?php submit_button( 'Save', 'button', 'save_fields') ?>
    </form>
</div>
</div>