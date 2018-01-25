<?php $nome = "Agenda"; $tabela = "agenda";?>
<div id="novanova">
	<div class="row">
		<div class="col-sm-2 col-xs-4">
			Prefixo<input id="prefixo" type="text" name="prefixo" class="form-control" placeholder="Dr,Dra...">
		</div>
		<div class="col-sm-10 col-xs-8">
			Pessoa<input id="cli_id" type="text" name="cli_id" class="form-control wd100" placeholder="Pessoa">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2 col-xs-12">
			Intervalo
			<select class="select2-selection select2-selection--single" style="width: 100%" id="intervalo">
				<option value="00:10:00">10 minuto(s)</option>
				<option value="00:20:00">20 minuto(s)</option>
				<option value="00:30:00">30 minuto(s)</option>
				<option value="00:40:00">40 minuto(s)</option>
				<option value="00:50:00">50 minuto(s)</option>
				<option value="01:00:00">1 hora(s)</option>
				<option value="02:00:00">2 horas(s)</option>
			</select>
		</div>
		<div class="col-sm-2 col-xs-6">
			Início H:
			<select class="select2-selection select2-selection--single" style="width: 100%" id="minTime">
				<option value="00">0 horas(s)</option>
				<option value="01">1 hora(s)</option>
				<option value="02">2 horas(s)</option>
				<option value="03">3 horas(s)</option>
				<option value="04">4 horas(s)</option>
				<option value="05">5 horas(s)</option>
				<option value="06">6 horas(s)</option>
				<option value="07">7 horas(s)</option>
				<option value="08">8 horas(s)</option>
				<option value="09">9 horas(s)</option>
				<option value="10">10 horas(s)</option>
				<option value="11">11 horas(s)</option>
				<option value="12">12 horas(s)</option>
				<option value="13">13 horas(s)</option>
				<option value="14">14 horas(s)</option>
				<option value="15">15 horas(s)</option>
				<option value="16">16 horas(s)</option>
				<option value="17">17 horas(s)</option>
				<option value="18">18 horas(s)</option>
				<option value="19">19 horas(s)</option>
				<option value="20">20 horas(s)</option>
				<option value="21">21 horas(s)</option>
				<option value="22">22 horas(s)</option>
			</select>
		</div>
		<div class="col-sm-3 col-xs-6">
			Inicio M:
			<select class="select2-selection select2-selection--single" style="width: 100%" id="minTime2">

			</select>
		</div>
		<div class="col-sm-2 col-xs-6">
			Término H:
			<select class="select2-selection select2-selection--single" style="width: 100%" id="maxTime">
				<option value="01">1 hora(s)</option>
				<option value="02">2 horas(s)</option>
				<option value="03">3 horas(s)</option>
				<option value="04">4 horas(s)</option>
				<option value="05">5 horas(s)</option>
				<option value="06">6 horas(s)</option>
				<option value="07">7 horas(s)</option>
				<option value="08">8 horas(s)</option>
				<option value="09">9 horas(s)</option>
				<option value="10">10 horas(s)</option>
				<option value="11">11 horas(s)</option>
				<option value="12">12 horas(s)</option>
				<option value="13">13 horas(s)</option>
				<option value="14">14 horas(s)</option>
				<option value="15">15 horas(s)</option>
				<option value="16">16 horas(s)</option>
				<option value="17">17 horas(s)</option>
				<option value="18">18 horas(s)</option>
				<option value="19">19 horas(s)</option>
				<option value="20">20 horas(s)</option>
				<option value="21">21 horas(s)</option>
				<option value="22">22 horas(s)</option>
				<option value="23">23 horas(s)</option>
			</select>
		</div>
		<div class="col-sm-3 col-xs-6">
			Término M:
			<select class="select2-selection select2-selection--single" style="width: 100%" id="maxTime2">

			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<label class="label label-success font-sm">Horário Almoço</label>
			<div class="row">
				<div class="col-sm-2 col-xs-4">
					<select class="select2-selection select2-selection--single" style="width: 100%" id="hr_ini">
						<option value="00">0 hr(s)</option>
						<option value="01">1 hr(s)</option>
						<option value="02">2 hr(s)</option>
						<option value="03">3 hr(s)</option>
						<option value="04">4 hr(s)</option>
						<option value="05">5 hr(s)</option>
						<option value="06">6 hr(s)</option>
						<option value="07">7 hr(s)</option>
						<option value="08">8 hr(s)</option>
						<option value="09">9 hr(s)</option>
						<option value="10">10 hr(s)</option>
						<option value="11">11 hr(s)</option>
						<option value="12">12 hr(s)</option>
						<option value="13">13 hr(s)</option>
						<option value="14">14 hr(s)</option>
						<option value="15">15 hr(s)</option>
						<option value="16">16 hr(s)</option>
						<option value="17">17 hr(s)</option>
						<option value="18">18 hr(s)</option>
						<option value="19">19 hr(s)</option>
						<option value="20">20 hr(s)</option>
						<option value="21">21 hr(s)</option>
						<option value="22">22 hr(s)</option>
						<option value="23">23 hr(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-8">
					<select class="select2-selection select2-selection--single" style="width: 100%" id="min_ini">
						<option value="00">0 min(s)</option>
						<option value="05">5 min(s)</option>
						<option value="10">10 min(s)</option>
						<option value="15">15 min(s)</option>
						<option value="20">20 min(s)</option>
						<option value="25">25 min(s)</option>
						<option value="30">30 min(s)</option>
						<option value="35">35 min(s)</option>
						<option value="40">40 min(s)</option>
						<option value="45">45 min(s)</option>
						<option value="50">50 min(s)</option>
						<option value="55">55 min(s)</option>
						<option value="60">60 min(s)</option>
					</select>
				</div>
				<div class="col-sm-2 col-xs-4">
					<select class="select2-selection select2-selection--single" style="width: 100%" id="hr_fim">
						<option value="00">0 hr(s)</option>
						<option value="01">1 hr(s)</option>
						<option value="02">2 hr(s)</option>
						<option value="03">3 hr(s)</option>
						<option value="04">4 hr(s)</option>
						<option value="05">5 hr(s)</option>
						<option value="06">6 hr(s)</option>
						<option value="07">7 hr(s)</option>
						<option value="08">8 hr(s)</option>
						<option value="09">9 hr(s)</option>
						<option value="10">10 hr(s)</option>
						<option value="11">11 hr(s)</option>
						<option value="12">12 hr(s)</option>
						<option value="13">13 hr(s)</option>
						<option value="14">14 hr(s)</option>
						<option value="15">15 hr(s)</option>
						<option value="16">16 hr(s)</option>
						<option value="17">17 hr(s)</option>
						<option value="18">18 hr(s)</option>
						<option value="19">19 hr(s)</option>
						<option value="20">20 hr(s)</option>
						<option value="21">21 hr(s)</option>
						<option value="22">22 hr(s)</option>
						<option value="23">23 hr(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-8">
					<select class="select2-selection select2-selection--single" style="width: 100%" id="min_fim">
						<option value="00">0 min(s)</option>
						<option value="05">5 min(s)</option>
						<option value="10">10 min(s)</option>
						<option value="15">15 min(s)</option>
						<option value="20">20 min(s)</option>
						<option value="25">25 min(s)</option>
						<option value="30">30 min(s)</option>
						<option value="35">35 min(s)</option>
						<option value="40">40 min(s)</option>
						<option value="45">45 min(s)</option>
						<option value="50">50 min(s)</option>
						<option value="55">55 min(s)</option>
						<option value="60">60 min(s)</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12" id="domingo">
			<label class="label label-danger font-sm">Domingo</label>
			<div class="row">
				<div class="col-sm-2 col-xs-6">Início H:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="inicio">
						<option value="00">0 hora(s)</option>
						<option value="01">1 hora(s)</option>
						<option value="02">2 horas(s)</option>
						<option value="03">3 horas(s)</option>
						<option value="04">4 horas(s)</option>
						<option value="05">5 horas(s)</option>
						<option value="06">6 horas(s)</option>
						<option value="07">7 horas(s)</option>
						<option value="08">8 horas(s)</option>
						<option value="09">9 horas(s)</option>
						<option value="10">10 horas(s)</option>
						<option value="11">11 horas(s)</option>
						<option value="12">12 horas(s)</option>
						<option value="13">13 horas(s)</option>
						<option value="14">14 horas(s)</option>
						<option value="15">15 horas(s)</option>
						<option value="16">16 horas(s)</option>
						<option value="17">17 horas(s)</option>
						<option value="18">18 horas(s)</option>
						<option value="19">19 horas(s)</option>
						<option value="20">20 horas(s)</option>
						<option value="21">21 horas(s)</option>
						<option value="22">22 horas(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-6">Inicio M:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="inicio_min">
					</select>
				</div>
				<div class="col-sm-2 col-xs-6">Fim:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="fim">
						<option value="00">0 hora(s)</option>
						<option value="01">1 hora(s)</option>
						<option value="02">2 horas(s)</option>
						<option value="03">3 horas(s)</option>
						<option value="04">4 horas(s)</option>
						<option value="05">5 horas(s)</option>
						<option value="06">6 horas(s)</option>
						<option value="07">7 horas(s)</option>
						<option value="08">8 horas(s)</option>
						<option value="09">9 horas(s)</option>
						<option value="10">10 horas(s)</option>
						<option value="11">11 horas(s)</option>
						<option value="12">12 horas(s)</option>
						<option value="13">13 horas(s)</option>
						<option value="14">14 horas(s)</option>
						<option value="15">15 horas(s)</option>
						<option value="16">16 horas(s)</option>
						<option value="17">17 horas(s)</option>
						<option value="18">18 horas(s)</option>
						<option value="19">19 horas(s)</option>
						<option value="20">20 horas(s)</option>
						<option value="21">21 horas(s)</option>
						<option value="22">22 horas(s)</option>
						<option value="23">23 horas(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-6">Fim M:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="fim_min">
					</select>
				</div>
			</div>
		</div>
		<div class="col-xs-12" id="segunda">
			<label class="label label-primary font-sm">Segunda-Feira</label>
			<div class="row">
				<div class="col-sm-2 col-xs-6">Início:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="inicio">
						<option value="00">0 hora(s)</option>
						<option value="01">1 hora(s)</option>
						<option value="02">2 horas(s)</option>
						<option value="03">3 horas(s)</option>
						<option value="04">4 horas(s)</option>
						<option value="05">5 horas(s)</option>
						<option value="06">6 horas(s)</option>
						<option value="07">7 horas(s)</option>
						<option value="08">8 horas(s)</option>
						<option value="09">9 horas(s)</option>
						<option value="10">10 horas(s)</option>
						<option value="11">11 horas(s)</option>
						<option value="12">12 horas(s)</option>
						<option value="13">13 horas(s)</option>
						<option value="14">14 horas(s)</option>
						<option value="15">15 horas(s)</option>
						<option value="16">16 horas(s)</option>
						<option value="17">17 horas(s)</option>
						<option value="18">18 horas(s)</option>
						<option value="19">19 horas(s)</option>
						<option value="20">20 horas(s)</option>
						<option value="21">21 horas(s)</option>
						<option value="22">22 horas(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-6">Inicio M:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="inicio_min">
					</select>
				</div>
				<div class="col-sm-2 col-xs-6">Fim:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="fim">
						<option value="00">0 hora(s)</option>
						<option value="01">1 hora(s)</option>
						<option value="02">2 horas(s)</option>
						<option value="03">3 horas(s)</option>
						<option value="04">4 horas(s)</option>
						<option value="05">5 horas(s)</option>
						<option value="06">6 horas(s)</option>
						<option value="07">7 horas(s)</option>
						<option value="08">8 horas(s)</option>
						<option value="09">9 horas(s)</option>
						<option value="10">10 horas(s)</option>
						<option value="11">11 horas(s)</option>
						<option value="12">12 horas(s)</option>
						<option value="13">13 horas(s)</option>
						<option value="14">14 horas(s)</option>
						<option value="15">15 horas(s)</option>
						<option value="16">16 horas(s)</option>
						<option value="17">17 horas(s)</option>
						<option value="18">18 horas(s)</option>
						<option value="19">19 horas(s)</option>
						<option value="20">20 horas(s)</option>
						<option value="21">21 horas(s)</option>
						<option value="22">22 horas(s)</option>
						<option value="23">23 horas(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-6">Fim M:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="fim_min">
					</select>
				</div>
			</div>
		</div>
		<div class="col-xs-12" id="terca">
			<label class="label label-primary font-sm">Terça-Feira</label>
			<div class="row">
				<div class="col-sm-2 col-xs-6">Início:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="inicio">
						<option value="00">0 hora(s)</option>
						<option value="01">1 hora(s)</option>
						<option value="02">2 horas(s)</option>
						<option value="03">3 horas(s)</option>
						<option value="04">4 horas(s)</option>
						<option value="05">5 horas(s)</option>
						<option value="06">6 horas(s)</option>
						<option value="07">7 horas(s)</option>
						<option value="08">8 horas(s)</option>
						<option value="09">9 horas(s)</option>
						<option value="10">10 horas(s)</option>
						<option value="11">11 horas(s)</option>
						<option value="12">12 horas(s)</option>
						<option value="13">13 horas(s)</option>
						<option value="14">14 horas(s)</option>
						<option value="15">15 horas(s)</option>
						<option value="16">16 horas(s)</option>
						<option value="17">17 horas(s)</option>
						<option value="18">18 horas(s)</option>
						<option value="19">19 horas(s)</option>
						<option value="20">20 horas(s)</option>
						<option value="21">21 horas(s)</option>
						<option value="22">22 horas(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-6">Inicio M:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="inicio_min">
					</select>
				</div>
				<div class="col-sm-2 col-xs-6">Fim:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="fim">
						<option value="00">0 hora(s)</option>
						<option value="01">1 hora(s)</option>
						<option value="02">2 horas(s)</option>
						<option value="03">3 horas(s)</option>
						<option value="04">4 horas(s)</option>
						<option value="05">5 horas(s)</option>
						<option value="06">6 horas(s)</option>
						<option value="07">7 horas(s)</option>
						<option value="08">8 horas(s)</option>
						<option value="09">9 horas(s)</option>
						<option value="10">10 horas(s)</option>
						<option value="11">11 horas(s)</option>
						<option value="12">12 horas(s)</option>
						<option value="13">13 horas(s)</option>
						<option value="14">14 horas(s)</option>
						<option value="15">15 horas(s)</option>
						<option value="16">16 horas(s)</option>
						<option value="17">17 horas(s)</option>
						<option value="18">18 horas(s)</option>
						<option value="19">19 horas(s)</option>
						<option value="20">20 horas(s)</option>
						<option value="21">21 horas(s)</option>
						<option value="22">22 horas(s)</option>
						<option value="23">23 horas(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-6">Fim M:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="fim_min">
					</select>
				</div>
			</div>
		</div>
		<div class="col-xs-12" id="quarta">
			<label class="label label-primary font-sm">Quarta-Feira</label>
			<div class="row">
				<div class="col-sm-2 col-xs-6">Início:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="inicio">
						<option value="00">0 hora(s)</option>
						<option value="01">1 hora(s)</option>
						<option value="02">2 horas(s)</option>
						<option value="03">3 horas(s)</option>
						<option value="04">4 horas(s)</option>
						<option value="05">5 horas(s)</option>
						<option value="06">6 horas(s)</option>
						<option value="07">7 horas(s)</option>
						<option value="08">8 horas(s)</option>
						<option value="09">9 horas(s)</option>
						<option value="10">10 horas(s)</option>
						<option value="11">11 horas(s)</option>
						<option value="12">12 horas(s)</option>
						<option value="13">13 horas(s)</option>
						<option value="14">14 horas(s)</option>
						<option value="15">15 horas(s)</option>
						<option value="16">16 horas(s)</option>
						<option value="17">17 horas(s)</option>
						<option value="18">18 horas(s)</option>
						<option value="19">19 horas(s)</option>
						<option value="20">20 horas(s)</option>
						<option value="21">21 horas(s)</option>
						<option value="22">22 horas(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-6">Inicio M:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="inicio_min">
					</select>
				</div>
				<div class="col-sm-2 col-xs-6">Fim:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="fim">
						<option value="00">0 hora(s)</option>
						<option value="01">1 hora(s)</option>
						<option value="02">2 horas(s)</option>
						<option value="03">3 horas(s)</option>
						<option value="04">4 horas(s)</option>
						<option value="05">5 horas(s)</option>
						<option value="06">6 horas(s)</option>
						<option value="07">7 horas(s)</option>
						<option value="08">8 horas(s)</option>
						<option value="09">9 horas(s)</option>
						<option value="10">10 horas(s)</option>
						<option value="11">11 horas(s)</option>
						<option value="12">12 horas(s)</option>
						<option value="13">13 horas(s)</option>
						<option value="14">14 horas(s)</option>
						<option value="15">15 horas(s)</option>
						<option value="16">16 horas(s)</option>
						<option value="17">17 horas(s)</option>
						<option value="18">18 horas(s)</option>
						<option value="19">19 horas(s)</option>
						<option value="20">20 horas(s)</option>
						<option value="21">21 horas(s)</option>
						<option value="22">22 horas(s)</option>
						<option value="23">23 horas(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-6">Fim M:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="fim_min">
					</select>
				</div>
			</div>
		</div>
		<div class="col-xs-12" id="quinta">
			<label class="label label-primary font-sm">Quinta-Feira</label>
			<div class="row">
				<div class="col-sm-2 col-xs-6">Início:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="inicio">
						<option value="00">0 hora(s)</option>
						<option value="01">1 hora(s)</option>
						<option value="02">2 horas(s)</option>
						<option value="03">3 horas(s)</option>
						<option value="04">4 horas(s)</option>
						<option value="05">5 horas(s)</option>
						<option value="06">6 horas(s)</option>
						<option value="07">7 horas(s)</option>
						<option value="08">8 horas(s)</option>
						<option value="09">9 horas(s)</option>
						<option value="10">10 horas(s)</option>
						<option value="11">11 horas(s)</option>
						<option value="12">12 horas(s)</option>
						<option value="13">13 horas(s)</option>
						<option value="14">14 horas(s)</option>
						<option value="15">15 horas(s)</option>
						<option value="16">16 horas(s)</option>
						<option value="17">17 horas(s)</option>
						<option value="18">18 horas(s)</option>
						<option value="19">19 horas(s)</option>
						<option value="20">20 horas(s)</option>
						<option value="21">21 horas(s)</option>
						<option value="22">22 horas(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-6">Inicio M:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="inicio_min">
					</select>
				</div>
				<div class="col-sm-2 col-xs-6">Fim:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="fim">
						<option value="00">0 hora(s)</option>
						<option value="01">1 hora(s)</option>
						<option value="02">2 horas(s)</option>
						<option value="03">3 horas(s)</option>
						<option value="04">4 horas(s)</option>
						<option value="05">5 horas(s)</option>
						<option value="06">6 horas(s)</option>
						<option value="07">7 horas(s)</option>
						<option value="08">8 horas(s)</option>
						<option value="09">9 horas(s)</option>
						<option value="10">10 horas(s)</option>
						<option value="11">11 horas(s)</option>
						<option value="12">12 horas(s)</option>
						<option value="13">13 horas(s)</option>
						<option value="14">14 horas(s)</option>
						<option value="15">15 horas(s)</option>
						<option value="16">16 horas(s)</option>
						<option value="17">17 horas(s)</option>
						<option value="18">18 horas(s)</option>
						<option value="19">19 horas(s)</option>
						<option value="20">20 horas(s)</option>
						<option value="21">21 horas(s)</option>
						<option value="22">22 horas(s)</option>
						<option value="23">23 horas(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-6">Fim M:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="fim_min">
					</select>
				</div>
			</div>
		</div>
		<div class="col-xs-12" id="sexta">
			<label class="label label-primary font-sm">Sexta-Feira</label>
			<div class="row">
				<div class="col-sm-2 col-xs-6">Início:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="inicio">
						<option value="00">0 hora(s)</option>
						<option value="01">1 hora(s)</option>
						<option value="02">2 horas(s)</option>
						<option value="03">3 horas(s)</option>
						<option value="04">4 horas(s)</option>
						<option value="05">5 horas(s)</option>
						<option value="06">6 horas(s)</option>
						<option value="07">7 horas(s)</option>
						<option value="08">8 horas(s)</option>
						<option value="09">9 horas(s)</option>
						<option value="10">10 horas(s)</option>
						<option value="11">11 horas(s)</option>
						<option value="12">12 horas(s)</option>
						<option value="13">13 horas(s)</option>
						<option value="14">14 horas(s)</option>
						<option value="15">15 horas(s)</option>
						<option value="16">16 horas(s)</option>
						<option value="17">17 horas(s)</option>
						<option value="18">18 horas(s)</option>
						<option value="19">19 horas(s)</option>
						<option value="20">20 horas(s)</option>
						<option value="21">21 horas(s)</option>
						<option value="22">22 horas(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-6">Inicio M:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="inicio_min">
					</select>
				</div>
				<div class="col-sm-2 col-xs-6">Fim:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="fim">
						<option value="00">0 hora(s)</option>
						<option value="01">1 hora(s)</option>
						<option value="02">2 horas(s)</option>
						<option value="03">3 horas(s)</option>
						<option value="04">4 horas(s)</option>
						<option value="05">5 horas(s)</option>
						<option value="06">6 horas(s)</option>
						<option value="07">7 horas(s)</option>
						<option value="08">8 horas(s)</option>
						<option value="09">9 horas(s)</option>
						<option value="10">10 horas(s)</option>
						<option value="11">11 horas(s)</option>
						<option value="12">12 horas(s)</option>
						<option value="13">13 horas(s)</option>
						<option value="14">14 horas(s)</option>
						<option value="15">15 horas(s)</option>
						<option value="16">16 horas(s)</option>
						<option value="17">17 horas(s)</option>
						<option value="18">18 horas(s)</option>
						<option value="19">19 horas(s)</option>
						<option value="20">20 horas(s)</option>
						<option value="21">21 horas(s)</option>
						<option value="22">22 horas(s)</option>
						<option value="23">23 horas(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-6">Fim M:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="fim_min">
					</select>
				</div>
			</div>
		</div>
		<div class="col-xs-12" id="sabado">
			<label class="label label-warning font-sm">Sábado</label>
			<div class="row">
				<div class="col-sm-2 col-xs-6">Início:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="inicio">
						<option value="00">0 hora(s)</option>
						<option value="01">1 hora(s)</option>
						<option value="02">2 horas(s)</option>
						<option value="03">3 horas(s)</option>
						<option value="04">4 horas(s)</option>
						<option value="05">5 horas(s)</option>
						<option value="06">6 horas(s)</option>
						<option value="07">7 horas(s)</option>
						<option value="08">8 horas(s)</option>
						<option value="09">9 horas(s)</option>
						<option value="10">10 horas(s)</option>
						<option value="11">11 horas(s)</option>
						<option value="12">12 horas(s)</option>
						<option value="13">13 horas(s)</option>
						<option value="14">14 horas(s)</option>
						<option value="15">15 horas(s)</option>
						<option value="16">16 horas(s)</option>
						<option value="17">17 horas(s)</option>
						<option value="18">18 horas(s)</option>
						<option value="19">19 horas(s)</option>
						<option value="20">20 horas(s)</option>
						<option value="21">21 horas(s)</option>
						<option value="22">22 horas(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-6">Inicio M:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="inicio_min">
					</select>
				</div>
				<div class="col-sm-2 col-xs-6">Fim:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="fim">
						<option value="00">0 hora(s)</option>
						<option value="01">1 hora(s)</option>
						<option value="02">2 horas(s)</option>
						<option value="03">3 horas(s)</option>
						<option value="04">4 horas(s)</option>
						<option value="05">5 horas(s)</option>
						<option value="06">6 horas(s)</option>
						<option value="07">7 horas(s)</option>
						<option value="08">8 horas(s)</option>
						<option value="09">9 horas(s)</option>
						<option value="10">10 horas(s)</option>
						<option value="11">11 horas(s)</option>
						<option value="12">12 horas(s)</option>
						<option value="13">13 horas(s)</option>
						<option value="14">14 horas(s)</option>
						<option value="15">15 horas(s)</option>
						<option value="16">16 horas(s)</option>
						<option value="17">17 horas(s)</option>
						<option value="18">18 horas(s)</option>
						<option value="19">19 horas(s)</option>
						<option value="20">20 horas(s)</option>
						<option value="21">21 horas(s)</option>
						<option value="22">22 horas(s)</option>
						<option value="23">23 horas(s)</option>
					</select>
				</div>
				<div class="col-sm-4 col-xs-6">Fim M:
					<select class="select2-selection select2-selection--single" style="width: 100%" id="fim_min">
					</select>
				</div>
			</div>
		</div>
	</div>
</div>

<br>

<div class="row">
	<div class="col-sm-12 center">
		<a href="javascript:void(0);" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CADASTRAR</a>
		<a href="javascript:void(0);" id="editar" class="btn btn-sm btn-warning hidden"> <span class="btn-label"><i class="glyphicon glyphicon-pencil"></i></span>EDITAR</a>
		<a href="javascript:void(0);" id="excluir" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>EXCLUIR</a>
		<a href="javascript:void(0);" id="cancelar" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-repeat"></i></span>CANCELAR</a>
		<a href="javascript:void(0);" id="salvar" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
	</div>
</div>
<script>

	$("#minTime2").html('<option value="00:00">0 min(s)</option>' +
		'<option value="10:00">10 min(s)</option>' +
		'<option value="20:00">20 min(s)</option>' +
		'<option value="30:00">30 min(s)</option>' +
		'<option value="40:00">40 min(s)</option>' +
		'<option value="50:00">50 min(s)</option>');

	$("#maxTime2").html('<option value="00:00">0 min(s)</option>' +
		'<option value="10:00">10 min(s)</option>' +
		'<option value="20:00">20 min(s)</option>' +
		'<option value="30:00">30 min(s)</option>' +
		'<option value="40:00">40 min(s)</option>' +
		'<option value="50:00">50 min(s)</option>');


	$("[id='inicio_min'],[id='fim_min']").html('<option value="00">0 min(s)</option>' +
		'<option value="10">10 min(s)</option>' +
		'<option value="20">20 min(s)</option>' +
		'<option value="30">30 min(s)</option>' +
		'<option value="40">40 min(s)</option>' +
		'<option value="50">50 min(s)</option>');

	$("#procedimentos").keyup(function(e){
		var regex = /^[a-zA-z0-9;\b]+$/;
		if (!regex.test(this.value.substr(this.value.length-1))) {
			this.value = this.value.substr(0,this.value.length-1);
		}else{
			return true;
		}
	});
	$(".select2-selection").select2();

	$("#novanova").find('input[id="cli_id"]').autocomplete({
		source: "ajax/buscaPro.php",
		select: function(event,ui){
			$(this).attr("retorno",ui.item.id);
			$(this).attr("value",ui.item.nome);
		},
		search:function(){
			loading('show');
		},
		response:function(){
			loading('hide')
		},
		delay:1000,
		minLength:3
	});
	$("#novanova").find('input[id="cli_id"]').autocomplete('option','appendTo',"div[id='novanova']");


	$("#intervalo").change(function(){
		if($(this).val().split(':')[1] == '10'){

			$("#minTime2").html('<option value="00:00">0 min(s)</option>' +
				'<option value="10:00">10 min(s)</option>' +
				'<option value="20:00">20 min(s)</option>' +
				'<option value="30:00">30 min(s)</option>' +
				'<option value="40:00">40 min(s)</option>' +
				'<option value="50:00">50 min(s)</option>');

			$("#maxTime2").html('<option value="00:00">0 min(s)</option>' +
				'<option value="10:00">10 min(s)</option>' +
				'<option value="20:00">20 min(s)</option>' +
				'<option value="30:00">30 min(s)</option>' +
				'<option value="40:00">40 min(s)</option>' +
				'<option value="50:00">50 min(s)</option>');

			$("[id='inicio_min'],[id='fim_min']").html('<option value="00">0 min(s)</option>' +
				'<option value="10">10 min(s)</option>' +
				'<option value="20">20 min(s)</option>' +
				'<option value="30">30 min(s)</option>' +
				'<option value="40">40 min(s)</option>' +
				'<option value="50">50 min(s)</option>');

			$("[id='inicio_min'],[id='fim_min']").select2('val','10');
		}
		else if($(this).val().split(':')[1] == '20'){

			$("#minTime2").html('<option value="00:00">0 min(s)</option>' +

				'<option value="20:00">20 min(s)</option>' +

				'<option value="40:00">40 min(s)</option>');

			$("#maxTime2").html('<option value="00:00">0 min(s)</option>' +

				'<option value="20:00">20 min(s)</option>' +

				'<option value="40:00">40 min(s)</option>');

			$("[id='inicio_min'],[id='fim_min']").html('<option value="00">0 min(s)</option>' +
				'<option value="20">20 min(s)</option>' +
				'<option value="40">40 min(s)</option>');
			$("[id='inicio_min'],[id='fim_min']").select2('val',$(this).val().split(':')[1]);
		}
		else if($(this).val().split(':')[1] == '30'){

			$("#minTime2").html('<option value="30:00">30 min(s)</option>');

			$("#maxTime2").html('<option value="30:00">30 min(s)</option>');

			$("[id='inicio_min'],[id='fim_min']").html('<option value="00">0 min(s)</option>' +
				'<option value="30">30 min(s)</option>');
			$("[id='inicio_min'],[id='fim_min']").select2('val',$(this).val().split(':')[1]);
		}
		else if($(this).val().split(':')[1] == '40'){

			$("#minTime2").html('<option value="40:00">40 min(s)</option>');

			$("#maxTime2").html('<option value="40:00">40 min(s)</option>');

			$("[id='inicio_min'],[id='fim_min']").html('<option value="00">0 min(s)</option>' +
				'<option value="40">40 min(s)</option>');
			$("[id='inicio_min'],[id='fim_min']").select2('val',$(this).val().split(':')[1]);
		}
		else if($(this).val().split(':')[1] == '50'){

			$("#minTime2").html('<option value="50:00">50 min(s)</option>');

			$("#maxTime2").html('<option value="50:00">50 min(s)</option>');

			$("[id='inicio_min'],[id='fim_min']").html('<option value="00">0 min(s)</option>' +
				'<option value="50">50 min(s)</option>');
			$("[id='inicio_min'],[id='fim_min']").select2('val',$(this).val().split(':')[1]);
		}
		else{
			$("#minTime2").html('<option value="00:00">0 min(s)</option>');

			$("#maxTime2").html('<option value="00:00">0 min(s)</option>');

			$("[id='inicio_min'],[id='fim_min']").html('<option value="00">0 min(s)</option>' +
				'<option value="10">10 min(s)</option>' +
				'<option value="20">20 min(s)</option>' +
				'<option value="30">30 min(s)</option>' +
				'<option value="40">40 min(s)</option>' +
				'<option value="50">50 min(s)</option>');

			$("[id='inicio_min'],[id='fim_min']").select2('val','00');
		}

	});

	$("#minTime").change(function(){
		$("[id='inicio']").select2('val',$(this).val());
	});
	$("#maxTime").change(function(){
		$("[id='fim']").select2('val',$(this).val());
	});

	$("#minTime2").change(function(){
		$("[id='inicio_min']").select2('val',$(this).val().split(':')[0]);
	});
	$("#maxTime2").change(function(){
		$("[id='fim_min']").select2('val',$(this).val().split(':')[0]);
	});
</script>
<?php

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		?>
		<script>
			//mostra botões ocultos;
			$("#editar, #excluir").removeClass("hidden");

			//oculta botões;
			$("#cadastrar").addClass("hidden");

			//bloqueia campos;
			// desabilita todos campos de entrada
			$("#novanova").find("input,textarea,select").each(function(){
				$(this).attr("disabled","disabled");
			});

			//busca campos no banco;
			$.post("server/recupera2.php",{tabela:'select agenda.pes_id, agenda.businessHours,agenda.almoco,agenda.slotDuration,agenda.minTime,agenda.maxTime, pessoa.nome as nome,agenda.id, agenda.prefixo from agenda,pessoa where pessoa.id = agenda.pes_id and agenda.id = "<?php echo $id;?>"'}).done(function(data){
				var obj = JSON.parse(data)[0];
				var hr_ini = obj.almoco.split('-')[0].split(':')[0];
				var min_ini = obj.almoco.split('-')[0].split(':')[1];
				var hr_fim = obj.almoco.split('-')[1].split(':')[0];
				var min_fim = obj.almoco.split('-')[1].split(':')[1];
				
				var businessHours = obj.businessHours.split('-');

				for(i in businessHours){
					if(businessHours[i].split(';')[0] == '0'){
						$("#domingo").find("#inicio").select2('val',businessHours[i].split(';')[1].split(":")[0]);
						$("#domingo").find("#inicio_min").select2('val',businessHours[i].split(';')[1].split(":")[1]);
						$("#domingo").find("#fim").select2('val',businessHours[i].split(';')[2].split(":")[0]);
						$("#domingo").find("#fim_min").select2('val',businessHours[i].split(';')[2].split(":")[1]);
					}
					else if(businessHours[i].split(';')[0] == '1'){
						$("#segunda").find("#inicio").select2('val',businessHours[i].split(';')[1].split(":")[0]);
						$("#segunda").find("#inicio_min").select2('val',businessHours[i].split(';')[1].split(":")[1]);
						$("#segunda").find("#fim").select2('val',businessHours[i].split(';')[2].split(":")[0]);
						$("#segunda").find("#fim_min").select2('val',businessHours[i].split(';')[2].split(":")[1]);
					}
					else if(businessHours[i].split(';')[0] == '2'){
						$("#terca").find("#inicio").select2('val',businessHours[i].split(';')[1].split(":")[0]);
						$("#terca").find("#inicio_min").select2('val',businessHours[i].split(';')[1].split(":")[1]);
						$("#terca").find("#fim").select2('val',businessHours[i].split(';')[2].split(":")[0]);
						$("#terca").find("#fim_min").select2('val',businessHours[i].split(';')[2].split(":")[1]);
					}
					else if(businessHours[i].split(';')[0] == '3'){
						$("#quarta").find("#inicio").select2('val',businessHours[i].split(';')[1].split(":")[0]);
						$("#quarta").find("#inicio_min").select2('val',businessHours[i].split(';')[1].split(":")[1]);
						$("#quarta").find("#fim").select2('val',businessHours[i].split(';')[2].split(":")[0]);
						$("#quarta").find("#fim_min").select2('val',businessHours[i].split(';')[2].split(":")[1]);
					}
					else if(businessHours[i].split(';')[0] == '4'){
						$("#quinta").find("#inicio").select2('val',businessHours[i].split(';')[1].split(":")[0]);
						$("#quinta").find("#inicio_min").select2('val',businessHours[i].split(';')[1].split(":")[1]);
						$("#quinta").find("#fim").select2('val',businessHours[i].split(';')[2].split(":")[0]);
						$("#quinta").find("#fim_min").select2('val',businessHours[i].split(';')[2].split(":")[1]);
					}
					else if(businessHours[i].split(';')[0] == '5'){
						$("#sexta").find("#inicio").select2('val',businessHours[i].split(';')[1].split(":")[0]);
						$("#sexta").find("#inicio_min").select2('val',businessHours[i].split(';')[1].split(":")[1]);
						$("#sexta").find("#fim").select2('val',businessHours[i].split(';')[2].split(":")[0]);
						$("#sexta").find("#fim_min").select2('val',businessHours[i].split(';')[2].split(":")[1]);
					}
					else if(businessHours[i].split(';')[0] == '6'){
						$("#sabado").find("#inicio").select2('val',businessHours[i].split(';')[1].split(":")[0]);
						$("#sabado").find("#inicio_min").select2('val',businessHours[i].split(';')[1].split(":")[1]);
						$("#sabado").find("#fim").select2('val',businessHours[i].split(';')[2].split(":")[0]);
						$("#sabado").find("#fim_min").select2('val',businessHours[i].split(';')[2].split(":")[1]);
					}
				}

				//alimenta formulário;
				$("#prefixo").val(obj.prefixo);
				$("#cli_id").attr('retorno',obj.pes_id);
				$("#cli_id").val(obj.nome);
				$("#intervalo").select2('val',obj.slotDuration);
				$("#minTime").select2('val',obj.minTime.split(":")[0]);
				$("#minTime2").select2('val',obj.maxTime.split(":")[1]+":"+obj.maxTime.split(":")[2]);
				$("#maxTime").select2('val',obj.maxTime.split(":")[0]);
				$("#maxTime2").select2('val',obj.maxTime.split(":")[1]+":"+obj.maxTime.split(":")[2]);
				$("#hr_ini").select2('val',hr_ini);
				$("#min_ini").select2('val',min_ini);
				$("#hr_fim").select2('val',hr_fim);
				$("#min_fim").select2('val',min_fim);
			});

			//editando formulário
			$("#editar").click(function(){
				//Liberar campos pra edição
				$("#novanova").find("input,textarea,select").each(function(){
					$(this).removeAttrs("disabled");
				});

				$("#cli_id").prop('disabled',true);

				//focar no primeiro campo
				$("#prefixo").focus().select();

				//esconde botões
				$("#excluir,#editar").addClass("hidden");

				//aparece botões
				$("#salvar,#cancelar").removeClass("hidden");
			});

			//excluindo item
			$("#excluir").click(function(){

				confirma("ATENÇÃO","Você deseja excluir este item?",function(){
					$.ajax({
						url: 'server/agenda.php',
						type: 'POST',
						cache: false,
						data: {funcao:3,id:"<?php echo $id;?>"},
						success: function(data) {
							if(data == 1){
								alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
								$.ajax({
									url: 'ajax/novaAgenda.php',
									type: 'GET',
									cache: false,
									success: function(data) {
										$("#content").html(data);
									}
								});
								$("#cadastro").dialog('close');
							}else{
								alerta("AVISO!","Não foi possível excluir este item!","danger","ban");
							}
						}
					});
				});
			});

			// cancelando edição
			$("#cancelar").click(function(){
				$.post("ajax/cadAgenda.php",{id:<?php echo $id;?>}).done(function(data){
					$("#cadastro").empty().html(data);
				}).fail(function(){
					alerta("ERRO!","Função não encontrada!","danger","warning");
				});
			});

			//salvando edição
			$("#salvar").click(function(){
				var prefixo 			= $("#prefixo").val();
				var pes_id  			= $("#cli_id").attr('retorno');
				var slotDuration 		= $("#intervalo").val();
				var minTime				= $("#minTime").val()+":"+$("#minTime2").val();
				var maxTime				= $("#maxTime").val()+":"+$("#maxTime2").val();
				var almoco				= $("#hr_ini").val()+":"+$("#min_ini").val()+"-"+$("#hr_fim").val()+":"+$("#min_fim").val();

				var businessHours		= '';
				if($("#domingo").find("#inicio option:selected").val()+":"+$("#domingo").find("#inicio_min option:selected").val() == '00:00'){

				}else{
					businessHours		+= "0;"+$("#domingo").find("#inicio option:selected").val()+":"+$("#domingo").find("#inicio_min option:selected").val()+';'+$("#domingo").find("#fim option:selected").val()+":"+$("#domingo").find("#fim_min option:selected").val();
				};

				if($("#segunda").find("#inicio option:selected").val()+":"+$("#segunda").find("#inicio_min option:selected").val() == '00:00'){

				}else{
					businessHours		+= "-1;"+$("#segunda").find("#inicio option:selected").val()+":"+$("#segunda").find("#inicio_min option:selected").val()+';'+$("#segunda").find("#fim option:selected").val()+":"+$("#segunda").find("#fim_min option:selected").val();
				};

				if($("#terca").find("#inicio option:selected").val()+":"+$("#terca").find("#inicio_min option:selected").val() == '00:00'){

				}else{
					businessHours		+= "-2;"+$("#terca").find("#inicio option:selected").val()+":"+$("#terca").find("#inicio_min option:selected").val()+';'+$("#terca").find("#fim option:selected").val()+":"+$("#terca").find("#fim_min option:selected").val();
				};

				if($("#quarta").find("#inicio option:selected").val()+":"+$("#quarta").find("#inicio_min option:selected").val() == '00:00'){

				}else{
					businessHours		+= "-3;"+$("#quarta").find("#inicio option:selected").val()+":"+$("#quarta").find("#inicio_min option:selected").val()+';'+$("#quarta").find("#fim option:selected").val()+":"+$("#quarta").find("#fim_min option:selected").val();
				};

				if($("#quinta").find("#inicio option:selected").val()+":"+$("#quinta").find("#inicio_min option:selected").val() == '00:00'){

				}else{
					businessHours		+= "-4;"+$("#quinta").find("#inicio option:selected").val()+":"+$("#quinta").find("#inicio_min option:selected").val()+';'+$("#quinta").find("#fim option:selected").val()+":"+$("#quinta").find("#fim_min option:selected").val();
				};

				if($("#sexta").find("#inicio option:selected").val()+":"+$("#sexta").find("#inicio_min option:selected").val() == '00:00'){

				}else{
					businessHours		+= "-5;"+$("#sexta").find("#inicio option:selected").val()+":"+$("#sexta").find("#inicio_min option:selected").val()+';'+$("#sexta").find("#fim option:selected").val()+":"+$("#sexta").find("#fim_min option:selected").val();
				};

				if($("#sabado").find("#inicio option:selected").val()+":"+$("#sabado").find("#inicio_min option:selected").val() == '00:00'){

				}else{
					businessHours		+= "-6;"+$("#sabado").find("#inicio option:selected").val()+":"+$("#sabado").find("#inicio_min option:selected").val()+';'+$("#sabado").find("#fim option:selected").val()+":"+$("#sabado").find("#fim_min option:selected").val();
				};




				if(pes_id == "" || pes_id == undefined){
					alerta("Aviso","Favor Selecionar uma pessoa","warning","warning");
				}else{
					loading('show');
					$.post('server/agenda.php',{funcao:2,id:"<?php echo $id;?>",prefixo:prefixo,pes_id:pes_id,slotDuration:slotDuration,minTime:minTime,maxTime:maxTime,almoco:almoco,businessHours:businessHours}).done(function(data){
						if(data == 1){
							sucesso();
							$("#cadastro").dialog('close');
						}else if(data == 2){
							alerta("Aviso!","Já existe uma agenda aberta para esta pessoa!","warning","warning");
						}else{
							erro();
						}
						loading('hide');
					});
				}
			});
		</script>
		<?php
	}else{
		?>
		<script type="text/javascript">

			$("#cadastrar").click(function(){
				var prefixo 			= $("#prefixo").val();
				var pes_id  			= $("#cli_id").attr('retorno');
				var slotDuration 		= $("#intervalo").val();
				var minTime				= $("#minTime").val()+":"+$("#minTime2").val();
				var maxTime				= $("#maxTime").val()+":"+$("#maxTime2").val();
				var almoco				= $("#hr_ini").val()+":"+$("#min_ini").val()+"-"+$("#hr_fim").val()+":"+$("#min_fim").val();

				var businessHours		= '';
				if($("#domingo").find("#inicio option:selected").val()+":"+$("#domingo").find("#inicio_min option:selected").val() == '00:00'){

				}else{
					businessHours		+= "0;"+$("#domingo").find("#inicio option:selected").val()+":"+$("#domingo").find("#inicio_min option:selected").val()+';'+$("#domingo").find("#fim option:selected").val()+":"+$("#domingo").find("#fim_min option:selected").val();
				};

				if($("#segunda").find("#inicio option:selected").val()+":"+$("#segunda").find("#inicio_min option:selected").val() == '00:00'){

				}else{
					businessHours		+= "-1;"+$("#segunda").find("#inicio option:selected").val()+":"+$("#segunda").find("#inicio_min option:selected").val()+';'+$("#segunda").find("#fim option:selected").val()+":"+$("#segunda").find("#fim_min option:selected").val();
				};

				if($("#terca").find("#inicio option:selected").val()+":"+$("#terca").find("#inicio_min option:selected").val() == '00:00'){

				}else{
					businessHours		+= "-2;"+$("#terca").find("#inicio option:selected").val()+":"+$("#terca").find("#inicio_min option:selected").val()+';'+$("#terca").find("#fim option:selected").val()+":"+$("#terca").find("#fim_min option:selected").val();
				};

				if($("#quarta").find("#inicio option:selected").val()+":"+$("#quarta").find("#inicio_min option:selected").val() == '00:00'){

				}else{
					businessHours		+= "-3;"+$("#quarta").find("#inicio option:selected").val()+":"+$("#quarta").find("#inicio_min option:selected").val()+';'+$("#quarta").find("#fim option:selected").val()+":"+$("#quarta").find("#fim_min option:selected").val();
				};

				if($("#quinta").find("#inicio option:selected").val()+":"+$("#quinta").find("#inicio_min option:selected").val() == '00:00'){

				}else{
					businessHours		+= "-4;"+$("#quinta").find("#inicio option:selected").val()+":"+$("#quinta").find("#inicio_min option:selected").val()+';'+$("#quinta").find("#fim option:selected").val()+":"+$("#quinta").find("#fim_min option:selected").val();
				};

				if($("#sexta").find("#inicio option:selected").val()+":"+$("#sexta").find("#inicio_min option:selected").val() == '00:00'){

				}else{
					businessHours		+= "-5;"+$("#sexta").find("#inicio option:selected").val()+":"+$("#sexta").find("#inicio_min option:selected").val()+';'+$("#sexta").find("#fim option:selected").val()+":"+$("#sexta").find("#fim_min option:selected").val();
				};

				if($("#sabado").find("#inicio option:selected").val()+":"+$("#sabado").find("#inicio_min option:selected").val() == '00:00'){

				}else{
					businessHours		+= "-6;"+$("#sabado").find("#inicio option:selected").val()+":"+$("#sabado").find("#inicio_min option:selected").val()+';'+$("#sabado").find("#fim option:selected").val()+":"+$("#sabado").find("#fim_min option:selected").val();
				};




				if(pes_id == "" || pes_id == undefined){
					alerta("Aviso","Favor Selecionar uma pessoa","warning","warning");
				}else{
					loading('show');
					$.post('server/agenda.php',{funcao:1,prefixo:prefixo,pes_id:pes_id,slotDuration:slotDuration,minTime:minTime,maxTime:maxTime,almoco:almoco,businessHours:businessHours}).done(function(data){
						if(data == 1){
							sucesso();
							$("#cadastro").dialog('close');
						}else if(data == 2){
							alerta("Aviso!","Já existe uma agenda aberta para esta pessoa!","warning","warning");
						}else{
							erro();
						}
						loading('hide');
					});
				}
			});
		</script>
		<?php
	}

?>

