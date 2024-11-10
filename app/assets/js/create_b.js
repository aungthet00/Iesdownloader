$(document).ready(function () {
	$(document)
		.ajaxStart(function () {
			$("#spinner").show();
			$("#submit").attr("disabled", true);
		})
		.ajaxStop(function () {
			$("#spinner").hide();
			$("#submit").removeAttr("disabled");
		});

		$("#lamp_categories").select2();
		$("#lamp").select2();
		$("#fixture").select2();
		$("#cri").select2();
		$("#cct").select2();
		$("#accessories").select2();

		$("#lamp_categories").val("");
		$("#lamp_categories").on("change", function(e) {
			$("#download").fadeOut();
			const groupSelected = $("option:selected", this);
			const valueSelected = this.value;

			if (valueSelected == "") {
				$("#lamp").empty().append(`<option value="">-- LED Module --</option>`).attr("disabled", true);
				$("#fixture").empty().append(`<option value="">-- Fixture --</option>`).attr("disabled", true);
				$("#cct").empty().append(`<option value="">-- CCT --</option>`).attr("disabled", true);
				$("#cri").empty().append(`<option value="">-- CRI --</option>`).attr("disabled", true);
				$("#accessories").empty().attr("disabled", true);
				return;
			}

			$.ajax({
				url: siteurl + "dashboard/get_lamps_by_category",
				method: "GET",
				data: {
					cat: valueSelected
				},
				success: function (response) {
					response = JSON.parse(response);
					if (response.status === 200) {
						//				  $("#message").fadeOut();
						$("#lamp").removeAttr("disabled");
						$("#fixture").empty().append(`<option value="">-- Fixture --</option>`).attr("disabled", true);
						$("#cct").empty().append(`<option value="">-- CCT --</option>`).attr("disabled", true);
						$("#cri").empty().append(`<option value="">-- CRI --</option>`).attr("disabled", true);
						$("#accessories").empty().attr("disabled", true);
						$("#lamp")
							.empty()
							.append('<option value="">-- LED Module --</option>');
						$("#accessories").empty().attr("disabled", true);
						$.each(response.data, function (index, lamp) {
							$("#lamp").append(
								`<option value="${lamp.id}">${lamp.module} ${lamp.category}</option>`
							);
						});
					}

					if (response.status === 404) {
						$("#error").text(response.status);
						$("#errormsg").text(response.error);
						//				  $("#message").fadeIn();

						$("#fixture").attr("disabled", true);
					}
				},
			});
		});
	$("#lamp").val("");
	$("#lamp").on("change", function (e) {
		$("#download").fadeOut();
		const lampSelected = $("option:selected", this);
		const valueSelected = this.value;

		if (valueSelected == "") {
			// $("#fixture").empty().append(`<option value="">-- Fixture --</option>`).attr("disabled", true);
			// $("#cct").empty().append(`<option value="">-- CCT --</option>`).attr("disabled", true);
			// $("#cri").empty().append(`<option value="">-- CRI --</option>`).attr("disabled", true);
			// $("#accessories").empty().attr("disabled", true);
			return;
		}

		$.ajax({
			url: siteurl + "dashboard/get_fixtures/" + valueSelected,
			method: "GET",
			success: function (response) {
				response = JSON.parse(response);
				if (response.status === 200) {
					//				  $("#message").fadeOut();
					if($("#fixture").children('option').length > 1) return;
					$("#fixture").removeAttr("disabled");
					$("#fixture")
						.empty()
						.append('<option value="">-- Fixture --</option>');
					$("#accessories").empty().attr("disabled", true);
					$.each(response.data, function (index, fixture) {
						$("#fixture").append(
							`<option value="${fixture.id}">${fixture.fixture} ${fixture.category}`
						);
					});
				}

				if (response.status === 404) {
					$("#error").text(response.status);
					$("#errormsg").text(response.error);
					//				  $("#message").fadeIn();

					$("#fixture").attr("disabled", true);
				}
			},
		});

		$.ajax({
			url: siteurl + "dashboard/get_cri_cct/" + valueSelected,
			method: "GET",
			success: function (response) {
				response = JSON.parse(response);
				if (response.status === 200) {

					if(response.data.cris.length === 1) 
					{
						console.log('checking');
						$("#cri").removeAttr("disabled").prop("required", true);
						$("#cri").empty().append(`<option value="${response.data.cris[0].id}">${response.data.cris[0].cri}</option>`);
					}

					if(response.data.ccts.length === 1)
					{
						$("#cct").removeAttr("disabled").prop("required", true);
						$("#cct").empty().append(`<option value="${response.data.ccts[0].id}">${response.data.ccts[0].cct}</option>`);
						return;
					}

					if(response.data.ccts.length === 3 && $("#cct").children('option').length === 4) return;
					if(response.data.ccts.length === 5 && $("#cct").children('option').length === 6) return;

					$("#cct").removeAttr("disabled").prop("required", true);
					$("#cri").removeAttr("disabled").prop("required", true);

					$("#cct").empty().append('<option value="">-- CCT --</option>');

					$.each(response.data.ccts, function (index, cct) {
						$("#cct").append(`<option value="${cct.id}">${cct.cct}</option>`);
					});

					if(response.data.ccts.length === 3 && response.data.cris.length === 1) return;

					$("#cri").empty().append('<option value="">-- CRI --</option>');
					$.each(response.data.cris, function (index, cri) {
						$("#cri").append(`<option value="${cri.id}">${cri.cri}</option>`);
					});
				}

				if (response.status === 404) {
					$("#cct").empty().append('<option value="">-- CCT --</option>').attr("disabled", true);
					$("#cri").empty().append('<option value="">-- CRI --</option>').attr("disabled", true);
				}
			},
		});
	});

	$("#fixture").on("change", function (e) {
		$("#download").fadeOut();
		const fixtureSelected = $("option:selected", this);
		const valueSelected = this.value;
		const lampid = $("#lamp").val();

		if (valueSelected == "") {
			$("#accessories").attr("disabled", "disabled");
			$("#accessories").empty();
			return;
		}

		$.ajax({
			url:
				siteurl + "dashboard/get_accessories/" + lampid + "/" + valueSelected,
			method: "GET",
			success: function (response) {
				response = JSON.parse(response);
				if (response.status === 200) {

					if($("#accessories").children('option').length > 1) return;


					$("#accessories").removeAttr("disabled");
					$("#accessories").empty();
					$.each(response.data, function (index, accessory) {
						$("#accessories").append(
							`<option value="${accessory.id}">${accessory.accessory}</option>`
						);
					});
					$('#accessories').select2();
				}

				if (response.status === 404) {
					$("#accessories").empty();
					$("#accessories").attr("disabled", "disabled");
				}
			},
		});
	});

	$("#accessories").change(function () {
		$("#download").fadeOut();
		const selectedOptions = $("#accessories option:selected");
		let isCPSelected = false;
		$.each(selectedOptions, function (index, value) {
			if (value.text === "CP") {
				isCPSelected = true;
			}
		});

		if (
			(isCPSelected === true && selectedOptions.length > 3) ||
			(isCPSelected === false && selectedOptions.length > 2)
		) {
			$("#accessories option:selected").prop("selected", false);
			$("#message").fadeIn();
			$("#error").text("Accessories:");
			$("#errormsg").text(
				"Select 3 accessories if CP is selected otherwise select 2."
			);
			setTimeout(() => $("#message").fadeOut(), 3000);
		}
	});

	$("#generate_form").submit(function (e) {
		$.ajax({
			url: `${siteurl}/dashboard/generate`,
			method: "POST",
			data: $("#generate_form").serialize(),
			success: function (data) {
				data = JSON.parse(data);

				const rows = [];
				let retString = "";

				let elementsInRow = ["IESNA:LM-63-2002"];
				rows.push(`${elementsInRow.join(" ")}`);

				elementsInRow = ["[TEST]", "ABSOLUTE"];
				rows.push(`${elementsInRow.join(" ")}`);

				elementsInRow = ["[TESTLAB]", "ELR"];
				rows.push(`${elementsInRow.join(" ")}`);

				let today = new Date();
				const dd = String(today.getDate()).padStart(2, "0");
				const mm = String(today.getMonth() + 1).padStart(2, "0");
				const yyyy = today.getFullYear();
				today = `${mm}/${dd}/${yyyy}`;

				elementsInRow = ["[ISSUEDATE]", today];
				rows.push(`${elementsInRow.join(" ")}`);

				elementsInRow = ["[MANUFAC]", "ELR"];
				rows.push(`${elementsInRow.join(" ")}`);

				elementsInRow = [
					"[LUMCAT]",
					data.fixture !== undefined
						? data.fixture.category
						: data.lamp.category,
				];
				rows.push(`${elementsInRow.join(" ")}`);

				if (data.fixture !== undefined) {
					elementsInRow = [
						"[LUMINAIRE]",
						data.accessories_names !== undefined
							? `${data.fixture.fixture} ${data.accessories_names}`
							: data.fixture.fixture,
					];
					rows.push(`${elementsInRow.join(" ")}`);
				}

				elementsInRow = [
					"[LAMP]",
					`${data.lamp.module} ${data.cct.cct} ${data.cri.cri}`,
				];
				rows.push(`${elementsInRow.join(" ")}`);

				elementsInRow = ["TILT=NONE"];
				rows.push(`${elementsInRow.join(" ")}`);

				elementsInRow = [
					1,
					data.cri.cri === 'HP' ? data.lamp.lumens_HP: data.lamp.lumens,
					1,
					data.vertical_angles,
					data.horizontal_angles,
					1,
					2,
					data.fixture !== undefined ? data.fixture.width : data.lamp.width,
					data.fixture !== undefined ? data.fixture.length : data.lamp.length,
					data.fixture !== undefined ? data.fixture.height : data.lamp.height,
				];
				rows.push(`${elementsInRow.join(" ")}`);

				elementsInRow = [1, 1, data.lamp.power];
				rows.push(`${elementsInRow.join(" ")}`);

				rows.push(`${data.y_values.join(" ")}`);
				retString = rows.join("\r\n");

				rows.push(`${data.x_values.join(" ")}`);

				for (let i = 0; i < data.result.length; i++) {
					rows.push(`${data.result[i].join(" ")}`);
				}
				retString = rows.join("\r\n");

				const file = new Blob([retString], { type: "text/plain" });

				const btn = $("#download");
				btn.attr("href", URL.createObjectURL(file));
				btn.prop("download", `${data.file_name}.ies`);

				$(btn).fadeIn();
			},
		});

		e.preventDefault();
	});

	$("#download").click(function (e) {
		// $(this).fadeOut();
		// $("#message").fadeIn();
		// $("#error").text("Success:");
		// $("#errormsg").text("File has been downloaded successfully.");
		// setTimeout(() => $("#message").fadeOut(), 3000);
	});

	$("#cct").change(function (e) {
		$("#download").fadeOut();
	});

	$("#cri").change(function (e) {
		$("#download").fadeOut();
	});
});
