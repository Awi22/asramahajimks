<div class="d-flex flex-start">
	<!--begin::Stats-->
	<div class="d-flex align-items-center border border-gray-300 border rounded py-2 mx-4 px-3 mb-3" style="background-color: #f4c7c3;">
		<div class="symbol symbol-50px me-10"><img src="public/assets/media/images/points.png" alt=""></div>
		<div class="d-flex justify-content-start flex-column">
			<div class="fw-semibold text-gray-800">Score</div>
			<div class="fs-4 text-center fw-bold text-gray-700">
				<span class="w-75px"><?= $totalScore ?></span>
			</div>
		</div>
	</div>
	<!--end::Stats-->
	<!--begin::Stats-->
	<div class="d-flex align-items-center border border-gray-300 border rounded py-2 mx-4 px-3 mb-3" style="background-color: #c8e6c9;">
		<div class="symbol symbol-50px me-10"><img src="public/assets/media/images/points.png" alt=""></div>
		<div class="d-flex justify-content-start flex-column">
			<div class="fw-semibold text-gray-800">Group</div>
			<div class="fs-4 text-center fw-bold text-gray-700">
				<span class="w-75px"><?= $totalGroup ?></span>
			</div>
		</div>
	</div>
	<!--end::Stats-->
</div>
<div class="table-responsive">
	<table id="table_scoring" class="table align-middle table-striped table-row-bordered gy-2">
		<thead>
			<?php
			echo '<tr class="fw-semibold fs-7 text-gray-800">';
			echo '<th rowspan="3" class="text-center align-middle" style="background-color: #00838f; color: white; padding-right: 10px;">Total Score</th>';
			foreach ($titleHead as $key => $value) {
				echo '<th class="text-center align-middle" style="background-color: #134f5c; color: white; padding-right: 10px;">' . $value . '</th>';
			}
			echo '</tr>';
			echo '<tr class="fw-semibold fs-7 text-gray-800">';
			// Title Score
			foreach ($titleScore as $key => $value) {
				echo '<th class="text-center align-middle" style="background-color: #f4c7c3 ; padding-right: 10px;">' . $value . '</th>';
			}
			echo '</tr>';
			echo '<tr class="fw-semibold fs-7 text-gray-800">';
			foreach ($titleGroup as $key => $value) {
				echo '<th class="text-center align-middle" style="background-color: #c8e6c9; padding-right: 10px;">' . $value . '</th>';
			}
			echo '</tr>';
			?>
		</thead>
		<tbody class="text-gray-700">
			<?php
			foreach ($dealer_code as $code_dealer => $nama_cabang) {
				echo '<tr>';
				unset($titleHead[0]);
				$totalScore = 0.0;
				foreach ($titleHead as $id => $val) {
					$sumScore = $functions->get_sum_score_perdealer($code_dealer, $id, $bulan_where_in);
					$decimal_ach = floatval($sumScore['score']) / 100.00;
					$decimal_bobot = floatval($sumScore['bobot4']) / 100.00;
					if (isset($sumScore['score'])) {
						if (floatval($sumScore['score']) > 100) {
							$totalScore += $sumScore['bobot4'];
						} else {
							$totalScore += number_format(($decimal_ach * $decimal_bobot) * 100, 2);
						}
					}
					if ($totalScore == 0) {
						$totalScore = '0.00';
					}
				}
				echo '<td class="text-center align-middle">' . $totalScore . '%' . '</td>';
				echo '<td class="align-middle w-125px">' . $nama_cabang . '</td>';
				foreach ($titleHead as $id => $val) {
					$sumScore = $functions->get_sum_score_perdealer($code_dealer, $id, $bulan_where_in);
					$score = '-';
					$decimal_ach = floatval($sumScore['score']) / 100.00;
					$decimal_bobot = floatval($sumScore['bobot4']) / 100.00;
					if (isset($sumScore['score'])) {
						if (floatval($sumScore['score']) > 100) {
							$score = $sumScore['bobot4'] . '%';
						} else {
							$score = number_format(($decimal_ach * $decimal_bobot) * 100, 2) . '%';
						}
					}
					if ($score == '0%') {
						$score = '0.00%';
					}
					echo '<td class="text-center align-middle">' . $score  . '</td>';
				}
				echo '</tr>';
			}
			?>
		</tbody>
	</table>
</div>
<!--end::Table-->

<!-- <script src="https://raw.githubusercontent.com/ashl1/datatables-rowsgroup/master/dataTables.rowsGroup.js"></script> -->
<script src="<?= base_url() ?>public/assets/js/datatables/dataTables.rowsGroup.js"></script>

<script>
	$(document).ready(function() {
		$("#table_scoring").DataTable({
			ordering: false, //disable sorting
			searching: false, //searching
			lengthChange: true, //menu kolom di kiri atas
			paginate: false, //disable paginate,
			filter: false, //disable filter/search
			info: false, //disable info row kiri bawah
			select: true
		});
	});
</script>