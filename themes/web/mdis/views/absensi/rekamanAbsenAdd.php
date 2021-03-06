<?php $this->load->view('header') ?>

<!-- CONTENT -->
<div id="content">
<div class="column full">
		
		<div class="box">
		<div class="box-header">Tambah Absen</div>
		<div class="box-content">
        <?php echo isAccess('absensi','masterAbsen','view') ? anchor('absensi/rekamanAbsen/view', '<span class="icon_text preview"></span>Rekaman Absen', 'class="button white"') : ''; ?>
        <br /><br />      
        
			<div id="loading" style="display:none;"><img src="loading.gif" alt="loading..." /></div>
        	<div id="result" style="display:none;"></div>
        	
            <?php if (isset($errorMessage)) : ?>
            	<div class="notification <?php echo ((isset($isSuccess) && $isSuccess) ? 'success' : 'error');?>"><?php echo $errorMessage; ?></div>
	        <?php endif; ?>    	
	        
	        <?php if (!(isset($isSuccess) && $isSuccess)) : ?>
            <?php  echo form_open('absensi/rekamanAbsen/add/time/' . time(),array('name'=>'formAddAbsen','id'=>'formAddAbsen'),array('kirim'=>'kirim')); ?>
            <table>
                <tr>
                    <td width="200">NIP</td>
                    <td><br />
                        <?php echo form_input(array('name'=>'nip','value'=>get_data($_POST,'nip'), 'class'=> 'form-field'));?>
                    </td>
                </tr>
                <tr>
                    <td>Absen</td>
                    <td><br />
                        <?php echo form_input(array('name'=>'absen','value'=>get_data($_POST,'absen'),'class'=>'form-field'));?>
                    </td>
                </tr>
				<tr>
                    <td>Tgl ABsen</td>
                    <td><br />
                        <?php echo form_input(array('name'=>'tgl_absen','value'=>get_data($_POST,'tgl_absen'),'class'=>'form-field'));?>
                    </td>
                </tr>
				<tr>
                    <td>Jam Masuk</td>
                    <td><br />
                        <?php echo form_input(array('name'=>'jam_masuk','value'=>get_data($_POST,'jam_masuk'),'class'=>'form-field'));?>
                    </td>
                </tr>
				<tr>
                    <td>Jam Keluar</td>
                    <td><br />
                        <?php echo form_input(array('name'=>'jam_keluar','value'=>get_data($_POST,'jam_keluar'),'class'=>'form-field'));?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <?php echo form_submit('submit','Simpan', 'class="button themed"');?>
                    </td>
                </tr>
            </table>
            </form>
			<?php endif;?>
			
          </div>
        </div>
      </div>
      <!-- End Widget-->
      
      <div class="clear"></div>
    </div>
  </div>
  
<?php $this->load->view('footer') ?>