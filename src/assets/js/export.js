import * as XLSX from "xlsx";
var dataConversionUtil = {};
//fileName文件名,tableHeader表头,dataList表数据
dataConversionUtil.dataToExcel = function (fileName, tableHeader, dataList) {
  let list = tableHeader.concat(dataList);
  let workSheet = XLSX.utils.aoa_to_sheet(list);
  let workBook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workBook, workSheet, "sheet1");
  XLSX.writeFile(workBook, fileName + ".xlsx");
};
export { dataConversionUtil };
