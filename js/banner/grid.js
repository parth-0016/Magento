varienGrid.prototype.doFilter = function () {
  var filters = $$(
    "#" + this.containerId + " .filter input",
    "#" + this.containerId + " .filter select"
  );
  filters.push(bannerBlockGrid_filter_parth);
//   filters.push(bannerGrid_filter_status_1);
  // console.log(filters); return;
  var elements = [];
  for (var i in filters) {
    if (filters[i].value && filters[i].value.length) elements.push(filters[i]);
  }
  if (
    !this.doFilterCallback ||
    (this.doFilterCallback && this.doFilterCallback())
  ) {
    this.reload(
      this.addVarToUrl(
        this.filterVar,
        encode_base64(Form.serializeElements(elements))
      )
    );
  }
};
