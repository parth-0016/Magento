document.observe("dom:loaded", function () {
  var formKey = FORM_KEY;
  $("loadReportButton").observe("click", function () {
    var tag = $F("activeTagDropdown");
    if (tag === "") {
      alert("Please select an active tag.");
      return;
    }

    new Ajax.Request(loadReportUrl, {
      method: "post",
      parameters: { tag: tag, form_key: formKey },
      onSuccess: function (response) {
        var reportDiv = $("productReport");
        reportDiv.innerHTML = "";

        try {
          var products = JSON.parse(response.responseText);
          if (products.length === 0) {
            reportDiv.innerHTML =
              "<p>No products found for the selected tag.</p>";
          } else {
            var table = new Element("table");
            var header = table.createTHead();
            var headerRow = header.insertRow(0);
            var keys = Object.keys(products[0]);

            keys.forEach(function (key, index) {
              var cell = headerRow.insertCell(index);
              cell.innerHTML = key;
            });

            var tbody = table.createTBody();
            products.forEach(function (product) {
              var row = tbody.insertRow();
              keys.forEach(function (key, index) {
                var cell = row.insertCell(index);
                cell.innerHTML = product[key];
              });
            });

            reportDiv.appendChild(table);
          }
        } catch (e) {
          console.error("Error parsing JSON:", e);
          reportDiv.innerHTML =
            "<p>Error loading report. Please try again.</p>";
        }
      },
      onFailure: function () {
        $("productReport").innerHTML =
          "<p>Error loading report. Please try again.</p>";
      },
    });
  });

  $("assignTagButton").observe("click", function () {
    var sku = $F("skuInput");
    var tag = $F("activeTagDropdown");

    if (!sku) {
      alert("Please enter a valid SKU.");
      return;
    }

    if (!tag) {
      alert("Please select an active tag.");
      return;
    }

    new Ajax.Request(assignTagUrl, {
      method: "post",
      parameters: { sku: sku, tag: tag, form_key: formKey },
      onSuccess: function (response) {
        var jsonResponse = JSON.parse(response.responseText);
        if (jsonResponse.success) {
          alert(jsonResponse.message);
        } else {
          $("assignSkuReport").innerHTML = jsonResponse.message;
        }
      },
      onFailure: function () {
        alert("Failed to assign tag. Please try again.");
      },
    });
  });
});