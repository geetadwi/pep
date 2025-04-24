<?php
ob_clean();
//$_objAdmin = new Admin();
/************************************* CSV For Category ***************************************/
if (isset($_POST['category_import_csv']) && $_POST['category_import_csv'] == 'yes') {
    $data = "Category Name*,Category Code\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"category_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['category_import']) && $_POST['category_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadCategoryFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Category Name*,Category Code\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/************************************* CSV For Category ***************************************/
/************************************* CSV For Color ***************************************/
if (isset($_POST['color_import_csv']) && $_POST['color_import_csv'] == 'yes') {
    $data = "Color Description*,Color Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"color_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['color_import']) && $_POST['color_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        //$_objItem->mysql_query("delete from table_color");
        $ret = $_objItem->uploadColorFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Color Description*,Color Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/************************************* CSV For Color ***************************************/
/************************************* CSV For Items ***************************************/
// if (isset($_POST['item_import_csv']) && $_POST['item_import_csv'] == 'yes') {
//     //$data="Category Name*,Item Code*,Item Description*,Size,D.P*,M R P*,Colors Code, Item Chain\n";
// //    $data = "Category Name*,Item Code*,Item Description*,Grams,D.P,M R P*,Cases Size*,Brand*,Item Erp Code,Variant Name,Sku Name,Tax Rate,Distributor Price,Stockist Price\n";
// //    $data = "Category Name*,Item Code*,Item Description*,Grams,Item MRP,Item PTR*,Cases Size*,Brand*,Item Erp Code,Variant Name,Sku Name,Tax Rate,".$AliaseUsers['distributor']." Price,".$AliaseUsers['stockist']." Price\n";
//     $data = "Item Code*,Item Description*, Brand*,Category Name*, Cases Size*,Grams,Tax Rate,Item MRP,Item PTR*," .
//         $AliaseUsers['distributor'] . " Price," . $AliaseUsers['stockist'] . " Price, Grade Name,HSN Code";
//     header("Content-type: application/octet-stream");
//     header("Content-Disposition: attachment; filename=\"item_sheet.csv\"");
//     echo $data;
//     die;
// }

if (isset($_POST['item_import_csv']) && $_POST['item_import_csv'] == 'yes') {
    $data = "Item Code*,Item Description*,Brand*,Category Name*,Sub Category Name,Cases Size*,Grams,Tax Rate,Item MRP,Item PTR*,".
        $AliaseUsers['distributor'] . " Price,". $AliaseUsers['stockist'] . " Price,Grade Name,HSN Code,Item Rank Name,FOC Item(Yes/No)";

    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"item_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['item_import']) && $_POST['item_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadItemListFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Item Code*,Item Description*, Brand*,Category Name*,Sub Category, Cases Size*,Grams,Tax Rate,Item MRP,Item PTR*," . $AliaseUsers['distributor'] . " Price," . $AliaseUsers['stockist'] . " Price, Grade Name,HSN Code,Item Rank Name,FOC Item(Yes/No)\n";

            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/************************************* CSV For Items ***************************************/
/************************************* CSV For Items PTR Files ***************************************/
if (isset($_REQUEST['items_prt_csv']) && $_REQUEST['items_prt_csv'] == 'yes') {
    $data = "State Name*,City Name*,Item Code*,PTR Price* \n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Items_PTR_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_item_ptr_file']) && $_POST['import_item_ptr_file'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->importItemsPTRFile();
        if ($ret == '') {
            $sus = "Items PTR has been added successfully.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($sus != '') {
            $sus = $sus;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),State Name*,City Name*,Item Code*,PTR Price* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
    //$sus="Item price has been added successfully.";
}
/************************************* CSV For Items PTR Files ***************************************/
/************************************* CSV For Distributor ***************************************/
if (isset($_POST['distributor_import_csv']) && $_POST['distributor_import_csv'] == 'yes') {
    $data = "" . $AliaseUsers['distributor'] . " Code," . $AliaseUsers['distributor'] . " Name*,Phone No1*,Phone No2," . $AliaseUsers['distributor'] . " Address,zipcode,State*,District*,City*,Contact Person1*,contact Phone No1*,Contact Person2,contact Phone No2,Email-ID1,Email-ID2," . $AliaseUsers['distributor'] . " Type," . $AliaseUsers['stockist'] . " Code*,GST No,Username,Password,Route Name\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['distributor'] . "_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['distributor_import']) && $_POST['distributor_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDistributorFile();
        if ($ret == '') {
            $msg = "Data has been successfully imported";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $dis_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['distributor'] . " Code," . $AliaseUsers['distributor'] . " Name*,Phone No1*,Phone No2," . $AliaseUsers['distributor'] . " Address,zipcode,State*,District*,City*,Contact Person1*,contact Phone No1*,Contact Person2,contact Phone No2,Email-ID1,Email-ID2," . $AliaseUsers['distributor'] . " Type," . $AliaseUsers['stockist'] . " Code*,GST No,Username,Password,Route Name\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/************************************* CSV For Distributor ***************************************/
/************************************* CSV For Stockist ***************************************/
if (isset($_POST['stockist_import_csv']) && $_POST['stockist_import_csv'] == 'yes') {
//    $data = "" . $AliaseUsers['stockist'] . " Name*,Phone No1*,Phone No2,Phone No3," . $AliaseUsers['stockist'] . " Address,State*,District*,City*,zipcode,Contact Person1*,contact Phone No1*,Contact Person2,contact Phone No2,Contact Person3,contact Phone No3,Email-ID1*,Email-ID2,Email-ID3,Number To Send SMS*," . $AliaseUsers['stockist'] . " Class," . $AliaseUsers['stockist'] . " Region," . $AliaseUsers['stockist'] . " Code*,Username,Password\n";
    $data = "" . $AliaseUsers['stockist'] . " Name*," . $AliaseUsers['stockist'] . " Code*,Phone No1*,State*,District*,City*,zipcode," . $AliaseUsers['stockist'] . " Address,Contact Person,Contact Phone No.,Email-ID1,Username,Password\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['stockist'] . "_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['stockist_import']) && $_POST['stockist_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadStockistFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $dis_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['stockist'] . " Name*," . $AliaseUsers['stockist'] . " Code*,Phone No1*,State*,District*,City*,zipcode," . $AliaseUsers['stockist'] . " Address,Contact Person,Contact Phone No.,Email-ID1,Username,Password\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/************************************* CSV For Stockist ***************************************/
/************************************* CSV For Retailer ***************************************/
if (isset($_POST['retailer_import_csv']) && $_POST['retailer_import_csv'] == 'yes') {
//
//    $data = "" . $AliaseUsers['retailer'] . " Name*,Phone No1*,Phone No2," . $AliaseUsers['retailer'] . " Address," . $AliaseUsers['retailer'] . " Market*,State*,District*,City*,Zipcode,Contact Person1*,contact Phone No1* ,Contact Person2,Contact Phone No2,Email-ID1*,Email-ID2," . $AliaseUsers['retailer'] . " Class, Route Name," . $AliaseUsers['retailer'] . " Channel," . $AliaseUsers['distributor'] . " Code*,Display Outlet," . $AliaseUsers['retailer'] . " Type,Username,Password,GST Number,PAN Number," . $AliaseUsers['retailer'] . " Code,Aadhar Number\n";
    $data = "" . $AliaseUsers['retailer'] . " Code," . $AliaseUsers['retailer'] . " Name*,Phone No1*,Phone No2,State*,District*,City*," . $AliaseUsers['retailer'] . " Market*,Zipcode," . $AliaseUsers['retailer'] . " Address, " . $AliaseUsers['retailer'] . " Group," . $AliaseUsers['retailer'] . " Channel*," . $AliaseUsers['retailer'] . " Class*," . $AliaseUsers['retailer'] . " Type*,GST Number, PAN Number,Aadhar Number,Display Outlet,Route Name,Contact Person1*,contact Phone No1* ,Email-ID1,Contact Person2,Contact Phone No2,Email-ID2, " . $AliaseUsers['distributor'] . " Code*,Username,Password\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['retailer'] . "_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['retailer_import']) && $_POST['retailer_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerFile();
        if ($ret == '') {
            $msg = "Data has been successfully imported";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $ret_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " Code," . $AliaseUsers['retailer'] . " Name*,Phone No1*,Phone No2,State*,District*,City*," . $AliaseUsers['retailer'] . " Market*,Zipcode," . $AliaseUsers['retailer'] . " Address, " . $AliaseUsers['retailer'] . " Group," . $AliaseUsers['retailer'] . " Channel*," . $AliaseUsers['retailer'] . " Class*," . $AliaseUsers['retailer'] . " Type*,GST Number, PAN Number,Aadhar Number,Display Outlet,Route Name,Contact Person1*,contact Phone No1* ,Email-ID1,Contact Person2,Contact Phone No2,Email-ID2, " . $AliaseUsers['distributor'] . " Code*,Username,Password\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/************************************* CSV For Retailer ***************************************/
/************************************* CSV For Salesman ***************************************/
/*
if(isset($_POST['salesman_import_csv']) && $_POST['salesman_import_csv']=='yes'){
	$data="Salesman Name*,State*,City*,Address,Phone No*\n";
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"salesman_sheet.csv\"");
	echo $data;
	die;
	}
if(isset($_POST['salesman_import']) && $_POST['salesman_import']=='yes'){
	if(isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name']!=""){
		$ret = $_objItem->uploadSalesmanFile();
		if($ret=='') {
			$msg= "File has been successfully imported.";
			}elseif($ret=='no') {
			$error= "Empty file";
			}else {
			$error= implode(",", $ret);
			}
			if($msg!=''){
			$sal_sus=$msg;
			}else{
			$data="Row Number(Please Delete The Row When Import),Salesman Name*,State*,City*,Address,Phone No*,Category Name \n";
			$data .="$error \n";
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"error.csv\"");
			echo $data;
			die;
			}
		}
	}*/
if (isset($_POST['salesman_import_csv']) && $_POST['salesman_import_csv'] == 'yes') {
//    $data = "".$AliaseUsers['salesman']." Name*,State*,District*,City*,Address,Phone No*,Username,Password,Category Name,".$AliaseUsers['salesman']." Designation,Reporting Person,Min Price Editable (Yes/No),".$AliaseUsers['salesman']." Code\n";
    $data = "" . $AliaseUsers['salesman'] . " Code," . $AliaseUsers['salesman'] . " Name*, Phone No*, Email Id,State*, District*, City*, Address, " . $AliaseUsers['salesman']
        . " Designation*,  Reporting Person*,Username*, Password* ,Min Price Editable (Yes/No), Joining Date(mm-dd-yyyy), Salary";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['salesman'] . "_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['salesman_import']) && $_POST['salesman_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadSalesmanFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sal_sus = $msg;
            $_SESSION['Sal_Succ'] = $msg;
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;
        } elseif ($error1 != '') {
            $cat_err = $error1;
            $_SESSION['Sal_err'] = $error1;
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;
        } else {
//            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['salesman'] . " Name*,State*,District*,City*,Address,Phone No*,Username,Password,Category Name," . $AliaseUsers['salesman'] . " Designation,Reporting Person,Min Price Editable (Yes/No)," . $AliaseUsers['salesman'] . " Code\n";
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['salesman'] . " Code," . $AliaseUsers['salesman'] . " Name*, Phone No*, Email Id,State*, District*, City*, Address, " . $AliaseUsers['salesman']
                . " Designation*,  Reporting Person*,Username*, Password* ,Min Price Editable (Yes/No),Joining Date(YYYY-MM-DD), Salary\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/************************************* CSV For Salesman ***************************************/
/************************************* CSV For City ***************************************/
if (isset($_REQUEST['district_import_csv']) && $_REQUEST['district_import_csv'] == 'yes') {
    $data = "State Name*, District Name*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"district_sheet.csv\"");
    echo $data;
    die;
}
/************************************* CSV For City ***************************************/
if (isset($_POST['district_import']) && $_POST['district_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDistrict();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),State Name*, District Name* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
if (isset($_REQUEST['city_state_import_csv']) && $_REQUEST['city_state_import_csv'] == 'yes') {
    $data = "State Name*,District Name*,City Name*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"city_sheet.csv\"");
    echo $data;
    die;
}
/************************************* CSV For City ***************************************/
if (isset($_POST['city_import']) && $_POST['city_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadstatecity();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),State Name*,District Name*,City Name*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/************************************* CSV For Stock ***************************************/
if (isset($_POST['stock_import_csv']) && $_POST['stock_import_csv'] == 'yes') {
    $data = "Item Code*,Quantity*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"item_stock_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['stock_import']) && $_POST['stock_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadstockDetails();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            // $data="Row Number(Please Delete The Row When Import),Category Name*, Item Code*, Color Code*, Quantity* \n";
            // $data="Row Number(Please Delete The Row When Import), Category Name*, Item Code*, Cases Size*, Number Of Cases*, Batch No \n";
            $data = "Row Number(Please Delete/Correct the row and Import Again), Item Code*, Quantity*, Batch No \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/************************************* CSV For Stock ***************************************/
/********************************* DISTRIBUTOR DISPATCHED STOCK IMPORT SECTION ****************************/
// if (isset($_POST['distributor_stock_import_csv']) && $_POST['distributor_stock_import_csv'] == 'yes') {
//     $data = "Stockist Code*,Distributor Code*, Item Code*, Bill No*, Bill Date*, Quantity*, Batch No, Rate, Invoice Value, Taxable Value, IGST Amount, CGST Amount, SGST Amount, Cess Amount,Bill Type(Invoice/Return)*\n";

if (isset($_POST['distributor_stock_import_csv']) && $_POST['distributor_stock_import_csv'] == 'yes') {
        $data = "Stockist Code*,Distributor Code*, Item Code*, Bill No*, Bill Date*, Quantity*, Rate, Invoice Value, Taxable Value, IGST Amount, CGST Amount, SGST Amount, Cess Amount,Bill Type(Invoice/Return)*\n";    
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"distributor_item_stock_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['distributor_stock_import']) && $_POST['distributor_stock_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDistributorDispatchstock();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete/Correct the rpe and Import Again),Stockist Code*, Distributor Code*, Item Code*, Bill No*, Bill Date*, Quantity*, Batch No, Rate, Invoice Value, Taxable Value, IGST Amount, CGST Amount, SGST Amount, Cess Amount,Bill Type(Invoice/Return)*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/********************************* DISTRIBUTOR DISPATCHED STOCK IMPORT SECTION ****************************/
/********************************* Retailer Dues ****************************/
if (isset($_REQUEST['retailer_dues_import_csv']) && $_REQUEST['retailer_dues_import_csv'] == 'yes') {
    $aDisRec = $_objAdmin->_getSelectList('table_retailer AS R LEFT JOIN state ON state.state_id = R.state LEFT JOIN city ON city.city_id = R.city ', 'retailer_id,retailer_name, state_name, city_name ', '', '');
    $data = "" . $AliaseUsers['retailer'] . " ID*," . $AliaseUsers['retailer'] . " Name*,Due Amount*, State, City\n";
    for ($i = 0; $i < count($aDisRec); $i++) {
        $retId = $aDisRec[$i]->retailer_id;
        $retName = $aDisRec[$i]->retailer_name;
        $amt = "";
        $stateName = $aDisRec[$i]->state_name;
        $cityName = $aDisRec[$i]->city_name;
        $data .= "$retId,$retName,$amt, $stateName,$cityName\n";
    }
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['retailer'] . "_due_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['retailer_due_import']) && $_POST['retailer_due_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerDueFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " ID*," . $AliaseUsers['retailer'] . " Name*,Due Amount* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/********************************* Retailer Dues ****************************/
/********************************* DISTRIBUTOR ACTUAL STOCK IMPORT SECTION(10 Sep 2014) ****************************/
if (isset($_POST['distributor_actual_stock_import_csv']) && $_POST['distributor_actual_stock_import_csv'] == 'yes') {
    $data = "" . $AliaseUsers['distributor'] . " Code*, Category Name*, Item Code*, Cases Size, Number Of Cases*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"distributor_actual_item_stock_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['distributor_actual_stock_import']) && $_POST['distributor_actual_stock_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDistributorActualStock();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['distributor'] . " Code*, Category Name*, Item Code*, Cases Sizes, Number Of Cases* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/********************************* DISTRIBUTOR ACTUAL STOCK IMPORT SECTION(10 Sep 2014) ****************************/
/****************************** For Route Assignment (Date: 29sep 2015)*********************/
// if(isset($_POST['route_assignment_import_csv']) && $_POST['route_assignment_import_csv']=='yes')
// {
// 	if($_SESSION['MonthSession']!=""){  $month=$_SESSION['MonthSession'];}
// 	if($_SESSION['YearSession']!=""){  $year=$_SESSION['YearSession'];}
// 	    $days            =cal_days_in_month(CAL_GREGORIAN, $month, $year);
// 	    $current_day_Val = date('d');
// 	    $current_month   =date('n');
// 	    $passing_month   =$month;
// 	    // if current day and month are current then download with current day
// 	    if($current_month==$passing_month){ $current_day_Val;} else{ $current_day_Val=1;}
// 	    $monthName       = date("F", mktime(0, 0, 0, $month, 10));
// 	    for($i=$current_day_Val;$i<=$days;$i++) {
// 		if($i<$days){ $comma=',';} else{ $comma='';}
// 		$dayValue.='day'.$i.$comma;
// 		}
// 	//echo $days; exit;
// 	$data="Salesman Name*, Route Name*, Year*, Month*,".$dayValue." \n";
// 	$data.=",,".$year.",".$monthName." ";
// 	header("Content-type: application/octet-stream");
// 	header("Content-Disposition: attachment; filename=\"route_list_sheet.csv\"");
// 	echo $data;
// 	die;
// }
if (isset($_POST['route_assignment_import_csv']) && $_POST['route_assignment_import_csv'] == 'yes') {
    // if($_SESSION['MonthSession']!=""){  $month=$_SESSION['MonthSession'];}
    // if($_SESSION['YearSession']!=""){  $year=$_SESSION['YearSession'];}
    //     $days            =cal_days_in_month(CAL_GREGORIAN, $month, $year);
    //     $current_day_Val = date('d');
    //     $current_month   =date('n');
    //     $passing_month   =$month;
    //     // if current day and month are current then download with current day
    //     if($current_month==$passing_month){ $current_day_Val;} else{ $current_day_Val=1;}
    //     $monthName       = date("F", mktime(0, 0, 0, $month, 10));
    //     for($i=$current_day_Val;$i<=$days;$i++) {
    // 	if($i<$days){ $comma=',';} else{ $comma='';}
    // 	$dayValue.='day'.$i.$comma;
    // 	}
    // //echo $days; exit;
    // $data="Salesman Name*, Route Name*, Year*, Month*,".$dayValue." \n";
    // $data.=",,".$year.",".$monthName." ";
    $data = $AliaseUsers['route']." Name*," . $AliaseUsers['salesman'] . " Code*,Assign Day*(Mon|Tue|Wed|Thu|Fri|Sat|Sun),From Date* (yyyy-mm-dd),To Date* (yyyy-mm-dd)\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"".$AliaseUsers['route']."_list_sheet.csv\"");
    echo $data;
    die;
}
/*********************** Import Monthly Route Assignment ***********************/
// if(isset($_POST['route_import_monthly']) && $_POST['route_import_monthly']=='yes'){
// if(isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name']!=""){
// 	$ret = $_objItem->uploadMonthlyRouteList();
// 	if($ret=='') {
// 		$msg= "File has been successfully imported.";
// 		}elseif($ret=='no') {
// 		$error= "Empty file";
// 		}else {
// 			$error= implode(",", $return);
// 		}
// 		if($msg!=''){
// 		$sus=$msg;
// 		}else{
// 		$data="Row Number(Please Delete The Row When Import),Salesman Name*, Route Name*, Year* ,Month*, \n";
// 		$data .="$error \n";
// 		header("Content-type: application/octet-stream");
// 		header("Content-Disposition: attachment; filename=\"error.csv\"");
// 		echo $data;
// 		die;
// 		}
// 	}
// }
if (isset($_POST['route_import_monthly']) && $_POST['route_import_monthly'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadMonthlyRouteList($salesman);
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            // $data="Row Number(Please Delete The Row When Import),".$AliaseUsers['salesman']." Name*, Route Name*, Year* ,Month*, \n";
            $data = "Row Number(Please Delete The Row When Import),".$AliaseUsers['route']." Name*," . $AliaseUsers['salesman'] . " Code*,Assign Day*(Mon|Tue|Wed|Thu|Fri|Sat|Sun),From Date* (yyyy-mm-dd),To Date* (yyyy-mm-dd)\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/*********************** Ends Import Monthly Route Assignment ***********************/
/************************** Route Import *******************************/
if (isset($_POST['route_import_csv']) && $_POST['route_import_csv'] == 'yes') {
    if ($_SESSION['RouteStateSession'] != '') {
        $state = "r.state='" . $_SESSION['RouteStateSession'] . "' ";
    }
    if ($_SESSION['RouteCitySession'] != '') {
        $city = "and r.city='" . $_SESSION['RouteCitySession'] . "' ";
    }
    if ($_SESSION['RouteMarketSession'] != '') {
        $market = "and r.retailer_location='" . $_SESSION['RouteMarketSession'] . "' ";
    }
    $auRec = $_objAdmin->_getSelectList('table_retailer as r left join state as s on s.state_id=r.state left join city as c on c.city_id=r.city', "r.retailer_id,r.retailer_name,r.retailer_location,s.state_name,c.city_name", '', " $state $city $market ");
    //echo "<pre>";
    //print_r($auRec);
    //exit;
    $data = "ID*, " . $AliaseUsers['retailer'] . "*, State*, City*, Market*, Route Name*\n";
    foreach ($auRec as $val) {
        $data .= "" . $val->retailer_id . "," . $val->retailer_name . "," . $val->state_name . "," . $val->city_name . "," . $val->retailer_location . ",\n";
    }
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"route_list_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['route_import']) && $_POST['route_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRouteList();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),ID*, " . $AliaseUsers['retailer'] . "*, State*, City*, Market*, Route Name* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/************* Route Import ***************/
/************* Distributor Target Import 2nd June 2015 (Gaurav)  ***************/
if (isset($_POST['distributor_target_import_csv']) && $_POST['distributor_target_import_csv'] == 'yes') {
    $data = "" . $AliaseUsers['distributor'] . " Code*, Item Code*, Cases Size*, Number Of Cases*, Target Type*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['distributor'] . "_target_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['distributor_target_import_import']) && $_POST['distributor_target_import_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDistributorTraget();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['distributor'] . " Code*, Item Code*, Cases Size*, Number Of Cases*,Target Type* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/************* Distributor Target Import 2nd June 2015 (Gaurav)  ***************/
/**********************************************************************************
 * DESC : Import salesman order by admin
 * Author : AJAY
 * created : 29th July 2015
 *
 **/
if (isset($_POST['order_import_csv']) && $_POST['order_import_csv'] == 'yes') {
    $data = "" . $AliaseUsers['salesman'] . " Name*, " . $AliaseUsers['salesman'] . " Phone*, " . $AliaseUsers['distributor'] . " Code*, " . $AliaseUsers['retailer'] . " Name*, " . $AliaseUsers['retailer'] . " Phone*, Bill Date, Bill No, Date of Order*, Item Code*, Qty* \n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"order_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['order_import']) && $_POST['order_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadOrdersFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $ret_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['salesman'] . " Name*, " . $AliaseUsers['salesman'] . " Phone*, " . $AliaseUsers['distributor'] . " Code*, " . $AliaseUsers['retailer'] . " Name*, " . $AliaseUsers['retailer'] . " Phone*, Bill Date, Bill No, Date of Order*, Item Code*, Qty* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"order_error.csv\"");
            echo $data;
            die;
        }
    }
}
/********************************* STOCKIST STOCK IMPORT SECTION ****************************/
if (isset($_POST['stockist_stock_import_csv']) && $_POST['stockist_stock_import_csv'] == 'yes') {
    $data = "" . $AliaseUsers['stockist'] . " Code*, Item Code*, Bill No*, Bill Date*, Quantity*,Rate, Invoice Value, Taxable Value, IGST Amount, CGST Amount, SGST Amount, Cess Amount\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"stockist_item_stock_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['stockist_stock_import']) && $_POST['stockist_stock_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadStockistStock();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            // $data="Row Number(Please Delete/Correct The Row and Import Again),Item Code*, Number Of Cases* , Lot No.\n";
            $data = "Row Number(Please Delete/Correct the row and Import Again), " . $AliaseUsers['stockist'] . " Code*, Item Code*, Bill No*, Bill Date*, Quantity*, Batch No, Rate, Invoice Value, Taxable Value, IGST Amount, CGST Amount, SGST Amount, Cess Amount\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/********************************* STOCKIST STOCK IMPORT SECTION ****************************/
/************************* Market Item Import Section***********************/
if (isset($_POST['market_item_import_csv']) && $_POST['market_item_import_csv'] == 'yes') {
    $data = "Category Name*,Item Name*,Item Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"market_item_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['market_item_import']) && $_POST['market_item_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadMarketItemListFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Category Name*,Item Name*,Item Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/************************* Market Item Import Section***********************/
/*******************************Integration start from here*********************************************************************************/
//Todo: Sagar: 12 April 2021
//import must sell products
if (isset($_POST['must_sell_items_import_csv']) && $_POST['must_sell_items_import_csv'] == 'yes') {
    $data = "State Name*,Product Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"must_sell_items_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['must_sell_items_import']) && $_POST['must_sell_items_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadMustSellItemImportFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),State Name*,Product Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//import statewise_minimum_item_price
if (isset($_POST['minimum_item_price_import_csv']) && $_POST['minimum_item_price_import_csv'] == 'yes') {
    $data = "State Name*,Product Code*,Minimum Price*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"minimum_item_price_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['minimum_item_price_import']) && $_POST['minimum_item_price_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadMinItemPriceImportFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),State Name*,Product Code*,Minimum Price*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/* * ******************************* CSV For Credit/Debit Invoices  ********************************** */
if (isset($_POST['credit_debit_invoice_import_csv']) && $_POST['credit_debit_invoice_import_csv'] == 'yes') {
    $data = "" . $AliaseUsers['distributor'] . " Code*," . $AliaseUsers['retailer'] . " Code*,Voucher No,Date*,Amount*,Invoice Type(Credit|Debit)*,Remarks,Invoice By(Pepup)*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"import_credit_debit_invoice.csv\"");
    echo $data;
    die;
}
if (isset($_POST['credit_debit_invoice_import']) && $_POST['credit_debit_invoice_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadCreditDebitInvoices();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['distributor'] . " Code*," . $AliaseUsers['retailer'] . " Code*,Voucher No,Date*,Amount*,Invoice Type(Credit|Debit)*,Remarks,Invoice By*(Pepup)\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/* * **************************** CSV For Credit/Debit Invoices********************************** */
//Todo Start: Sagar : 21 July - import state master
if (isset($_POST['state_import_csv']) && $_POST['state_import_csv'] == 'yes') {
    $data = "Country Name*,State Name*,State Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"state_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['state_import']) && $_POST['state_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadStateListFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Country Name*,State Name*,State Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End: Sagar : 21 July - import state master
//Todo Start: Sagar : 19 Aug 2021 - import market category master
if (isset($_POST['market_category_import_csv']) && $_POST['market_category_import_csv'] == 'yes') {
    $data = "Category Name*,Category Code\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"market_category_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['market_category_import']) && $_POST['market_category_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadMarketCategoryFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
            //print($error);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Category Name*,Category Code\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End: Sagar : 19 Aug 2021 - import market category master
//Todo Start: Sagar : 31st Aug 2021 - import Retailer Wise Product Price
if (isset($_POST['ret_wise_item_price_import_csv']) && $_POST['ret_wise_item_price_import_csv'] == 'yes') {
    $data = "" . $AliaseUsers['retailer'] . " Code*,Item Code*,Price*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"ret_wise_item_price_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['ret_wise_item_price_import']) && $_POST['ret_wise_item_price_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerWiseItemPriceFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " Code*,Item Code*,Price*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End: Sagar : 31st Aug 2021 - import Retailer Wise Product Price
//Todo Start: Sagar : 2nd Sep 2021 - import Enquiry
if (isset($_POST['enquiry_import_csv']) && $_POST['enquiry_import_csv'] == 'yes') {
    $data = "Customer Name*,Customer Channel*,Customer Phone No*,State*,City*,Area*,Enquiry*,Enquiry Source,Enquiry Type,Enquiry Status," . $AliaseUsers['salesman'] . " Code*,Quantity Enquired\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"enquiry_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['enquiry_import']) && $_POST['enquiry_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadEnquiryDetails();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete/Correct the row and Import Again),Customer Name*,Customer Channel*,Customer Phone No*,State*,City*,Area*,Enquiry*,Enquiry Source,Enquiry Type,Enquiry Status," . $AliaseUsers['salesman'] . " Code*,Quantity Enquired\n";
            $data .= "$error\n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End: Sagar : 2nd Sep 2021 - import Enquiry
//Todo start: Sagar : 2nd Sep 2021 - import Project
if (isset($_POST['project_import_csv']) && $_POST['project_import_csv'] == 'yes') {
    //$data="Category Name*,Item Code*,Item Description*,Size,D.P*,M R P*,Colors Code, Item Chain\n";
    $data = "Project Name*,Project Type*,Customer Code,Dealer code,Zone*,Project Zone,Specification Month,Maturity Date," . $AliaseUsers['salesman'] . " Code*,Project Location,Department Code,Project Category,Projected Qty,Specification Type,Product Type,Item Name,Brand Name,Order Qty\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"project_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['project_import']) && $_POST['project_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadProjectListFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Project Name*,Project Type*,Customer Name*,Dealer Name*,Zone*,Project Zone*,Specification Month*,Maturity Date," . $AliaseUsers['salesman'] . " Code*,Project Location*,Department Code*,Project Category*,Projected Qty*,Specification Type*,Product Type*,Item Name*,Brand Name*,Order Qty*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End: Sagar : 2nd Sep 2021 - import Project
/* * **************************** For Route Assignment (Date: 29sep 2015)******************** */
if (isset($_POST['route_assignment_by_month_import_csv']) && $_POST['route_assignment_by_month_import_csv'] == 'yes') {
    if ($_SESSION['MonthSession'] != "") {
        $month = $_SESSION['MonthSession'];
    } else {
        $month = date('m');
    }
    if ($_SESSION['YearSession'] != "") {
        $year = $_SESSION['YearSession'];
    } else {
        $year = date('Y');
    }
    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $monthName = date("F", mktime(0, 0, 0, $month, 10));
    for ($i = 1; $i <= $days; $i++) {
        if ($i < $days) {
            $comma = ',';
        } else {
            $comma = '';
        }
        $dateStr = $year . '-' . $month . '-' . $i;
        $dayName = date('D', strtotime($dateStr));
        $dayValue .= 'Day-' . $i . '  (' . $dayName . ') ' . $comma;
    }
    $data = $AliaseUsers['route']." Name*, " . $AliaseUsers['salesman'] . " Code*, Year*, Month*," . $dayValue . " \n";
    $data .= ",," . $year . "," . $monthName . " ";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"".$AliaseUsers['route']."_assignment_by_month_sheet.csv\"");
    echo $data;
    die;
}
/* * ********************* Import Monthly Route Assignment ********************** */
if (isset($_POST['route_assignment_by_month_import']) && $_POST['route_assignment_by_month_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadMonthWiseRouteList($salesman);
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            if ($_SESSION['MonthSession'] != "") {
                $month = $_SESSION['MonthSession'];
            }
            if ($_SESSION['YearSession'] != "") {
                $year = $_SESSION['YearSession'];
            }
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($i = 1; $i <= $days; $i++) {
                if ($i < $days) {
                    $comma = ',';
                } else {
                    $comma = '';
                }
                $dateStr = $year . '-' . $month . '-' . $i;
                $dayName = date('D', strtotime($dateStr));
                $dayValue .= 'Day-' . $i . '  (' . $dayName . ') ' . $comma;
            }
            $data = "Row Number(Please Delete The Row When Import), ".$AliaseUsers['route']." Name*, " . $AliaseUsers['salesman'] . " Code*, Year* ,Month*, " . $dayValue . " \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/* * ********************* Ends Import Monthly Route Assignment ********************** */
//Todo Start: Sagar: 28th Sep 2021: import Salesman Retailer Assignment
if (isset($_POST['retailer_assignment_import_csv']) && $_POST['retailer_assignment_import_csv'] == 'yes') {
    if ($_SESSION['MonthSession'] != "") {
        $month = $_SESSION['MonthSession'];
    }
    if ($_SESSION['YearSession'] != "") {
        $year = $_SESSION['YearSession'];
    }
    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $current_day_Val = date('d');
    $current_month = date('n');
    $passing_month = $month;
    // if current day and month are current then download with current day
    //if($current_month==$passing_month){ $current_day_Val;} else{ $current_day_Val=1;}
    $monthName = date("F", mktime(0, 0, 0, $month, 10));
    for ($i = 1; $i <= $days; $i++) {
        $dayName = date('Y-m-d', strtotime($year . '-' . $month . '-' . $i));
        if ($i < $days) {
            $comma = ',';
        } else {
            $comma = '';
        }
        $dayValue .= 'day' . $i . '(' . date('D', strtotime($dayName)) . ')' . $comma;
    }
    //echo $days; exit;
    $data = "" . $AliaseUsers['salesman'] . " Code*, Customer Code*, Year*, Month*," . $dayValue . " \n";
    $data .= ",," . $year . "," . $monthName . " ";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['retailer'] . "_assignment_list_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['retailer_assignment_import_monthly']) && $_POST['retailer_assignment_import_monthly'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadMonthlySalesmanRetailerAssignmentList($salesman);
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['salesman'] . " Code*, Customer Code*, Year* ,Month*,";
            if ($_SESSION['MonthSession'] != "") {
                $month = $_SESSION['MonthSession'];
            }
            if ($_SESSION['YearSession'] != "") {
                $year = $_SESSION['YearSession'];
            }
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $current_day_Val = date('d');
            $current_month = date('n');
            $passing_month = $month;
            // if current day and month are current then download with current day
            //if($current_month==$passing_month){ $current_day_Val;} else{ $current_day_Val=1;}
            $monthName = date("F", mktime(0, 0, 0, $month, 10));
            for ($i = 1; $i <= $days; $i++) {
                $dayName = date('Y-m-d', strtotime($year . '-' . $month . '-' . $i));
                if ($i < $days) {
                    $comma = ',';
                } else {
                    $comma = '';
                }
                $data .= 'day' . $i . '(' . date('D', strtotime($dayName)) . ')' . $comma;
            }
            $data .= "\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End: Sagar: 28th Sep 2021: import Salesman Retailer Assignment
//Todo Start: Ankit: 09th Nov 2021: import CSV For Brands
if (isset($_REQUEST['brands_import_csv']) && $_REQUEST['brands_import_csv'] == 'yes') {
    $data = "Brands Name*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"brands_sheet.csv\"");
    echo $data;
    die;
}
//Todo Start: Ankit: 28th Sep 2021: import CSV For Brands
if (isset($_POST['brands_import']) && $_POST['brands_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadbrands();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Brands Name* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo END: Ankit: 28th Sep 2021: import CSV For Brands
//Todo Start : Sagar : 14th Feb 2021 Salesman & Customer Mapping
if (isset($_POST['customer_salesman_mapping_import_csv']) && $_POST['customer_salesman_mapping_import_csv'] == 'yes') {
    $data = "Customer Code*," . $AliaseUsers['salesman'] . " Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"customer_" . $AliaseUsers['salesman'] . "_mapping_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['customer_salesman_mapping_import']) && $_POST['customer_salesman_mapping_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadCustomerSalesmanMappingFile($salesman);
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sal_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Customer Code*," . $AliaseUsers['salesman'] . " Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End : Sagar : 14th Feb 2021 Salesman & Customer Mapping
/************************Customer contact import created by sachin on 3rd march 2022***************************************/
if (isset($_POST['customer_contact_import_csv']) && $_POST['customer_contact_import_csv'] == 'yes') {
    $data = "" . $AliaseUsers['retailer'] . " Code*,Contact Name*,Phone No1*,Designation*,email id,Phone No2\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"customer_contact_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['customer_contact_import']) && $_POST['customer_contact_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadCustomerContact();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sal_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " Code*,Contact Name*,Phone No1*,Designation*,email id,Phone No2,\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo Start : Ankit : 05th Apr 2022 Route Mapping
if (isset($_POST['route_new_import_csv']) && $_POST['route_new_import_csv'] == 'yes') {
    $data = "" . $AliaseUsers['retailer'] . " Code*, " . $AliaseUsers['route'] ." Name*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"".$AliaseUsers['route']."_list_new_sheet.csv\"");
    echo $data;
    die;
} 
if (isset($_POST['route_new_import']) && $_POST['route_new_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadNewRouteList();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            // $data="Row Number(Please Delete The Row When Import),Salesman Name*, Route Name*, Year* ,Month*, \n";
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " Code*, " . $AliaseUsers['route'] ." Name* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End : Ankit : 05th Apr 2022 Route Mapping
//Todo Start : Ankit : 11th Apr 2022 Designation Wise Route Assignment
if (isset($_POST['route_assignment_by_month_designtion_wise_import_csv']) && $_POST['route_assignment_by_month_designtion_wise_import_csv'] == 'yes') {
    if ($_SESSION['MonthSession'] != "") {
        $month = $_SESSION['MonthSession'];
    } else {
        $month = date('m');
    }
    if ($_SESSION['YearSession'] != "") {
        $year = $_SESSION['YearSession'];
    } else {
        $year = date('Y');
    }
    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $current_day_Val = date('d');
    $current_month = date('n');
    $passing_month = $month;
    // if current day and month are current then download with current day
    //    if($current_month==$passing_month){ $current_day_Val;} else{ $current_day_Val=1;}
    $monthName = date("F", mktime(0, 0, 0, $month, 10));
    //    for($i=$current_day_Val;$i<=$days;$i++) {
    // if($i<$days){ $comma=',';} else{ $comma='';}
    // $dayValue.='day'.$i.$comma;
    // }
    for ($i = 1; $i <= $days; $i++) {
        if ($i < $days) {
            $comma = ',';
        } else {
            $comma = '';
        }
        $dayValue .= 'day' . $i . $comma;
    }
    // $data="Route Name*, Salesman Pepup Code*, Sales Organization*, Year*, Month*,".$dayValue." \n";
    $data = "Route Name*, " . $AliaseUsers['salesman'] . " Pepup Code*, Year*, Month*," . $dayValue . " \n";
    $data .= ",," . $year . "," . $monthName . " ";
    // $data="Route Name*, Salesman Pepup Code*,  Assign Day*(Mon|Tue|Wed|Thu|Fri|Sat|Sat|Sun)\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"designation_wise_route_assignment_by_month_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['designation_wise_route_assignment_by_month_import']) && $_POST['designation_wise_route_assignment_by_month_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDesigantionWiseMonthWiseRouteList();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            if ($_SESSION['MonthSession'] != "") {
                $month = $_SESSION['MonthSession'];
            }
            if ($_SESSION['YearSession'] != "") {
                $year = $_SESSION['YearSession'];
            }
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $current_day_Val = date('d');
            $current_month = date('n');
            $passing_month = $month;
            // if current day and month are current then download with current day
            //    if($current_month==$passing_month){ $current_day_Val;} else{ $current_day_Val=1;}
            //    $monthName       = date("F", mktime(0, 0, 0, $month, 10));
            //    for($i=$current_day_Val;$i<=$days;$i++) {
            // 	if($i<$days){ $comma=',';} else{ $comma='';}
            // 	$dayValue.='day'.$i.$comma;
            // }
            for ($i = 1; $i <= $days; $i++) {
                if ($i < $days) {
                    $comma = ',';
                } else {
                    $comma = '';
                }
                $dayValue .= 'day' . $i . $comma;
            }
            // $data="Row Number(Please Delete The Row When Import), Route Name*, Salesman Pepup Code*, Sales Organization*, Year* ,Month*, ".$dayValue." \n";
            $data = "Row Number(Please Delete The Row When Import), Route Name*, " . $AliaseUsers['salesman'] . " Pepup Code*, Year* ,Month*, " . $dayValue . " \n";
            // $data="Row Number(Please Delete The Row When Import),Route Name*, Salesman Pepup Code*, Sales Organization*, Assign Day*(Mon|Tue|Wed|Thu|Fri|Sat|Sat|Sun) \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End : Ankit : 11th Apr 2022 Designation Wise Route Assignment
//Todo Start : Ankit : 13th Apr 2022 Retailer Target Import
if (isset($_POST['retailer_target_import_csv']) && $_POST['retailer_target_import_csv'] == 'yes') {
    $data = "" . $AliaseUsers['retailer'] . " Code*, Month*, Year*, Target Value*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['retailer'] . "_target_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_retailer_target']) && $_POST['import_retailer_target'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerTarget();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            // $data="Row Number(Please Delete The Row When Import),Salesman Name*, Route Name*, Year* ,Month*, \n";
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " Code*, Month*, Year*, Target Value* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End : Ankit : 13th Apr 2022 Retailer Target Import
//Todo Start: Sagar : 18th May 2022 : Import MGB Norms
if (isset($_POST['mgb_norms_import_csv']) && $_POST['mgb_norms_import_csv'] == 'yes') {
    if (isset($_REQUEST['upload_type']) && $_REQUEST['upload_type'] == 'r_w_u') {
        $data = "" . $AliaseUsers['retailer'] . " Code*,Product Code*,Norms*,Start Date*,End Date\n";
        $upload_type = '_' . $AliaseUsers['retailer'] . '_wise';
    } else if (isset($_REQUEST['upload_type']) && $_REQUEST['upload_type'] == 's_w_u') {
        $data = "State Name*,Classification Code,Product Code*,Norms*,Start Date*,End Date\n";
        $upload_type = '_state_wise';
    } else if (isset($_REQUEST['upload_type']) && $_REQUEST['upload_type'] == 'c_w_u') {
        $data = "City Name*,Classification Code,Product Code*,Norms*,Start Date*,End Date\n";
        $upload_type = '_city_wise';
    } else {
        $data = "Product Code*,Classification Code,Norms*,Start Date*,End Date\n";
        $upload_type = '_item_wise';
    }
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"mgb_norms_sheet$upload_type.csv\"");
    echo $data;
    die;
}
if (isset($_POST['mgb_norms_import']) && $_POST['mgb_norms_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $dataFelds = "";
        if (isset($_REQUEST['upload_type']) && $_REQUEST['upload_type'] == 'r_w_u') {
            $ret = $_objItem->uploadMGBNormsFileRetailer();
            $dataFelds = "" . $AliaseUsers['retailer'] . " Code*,Product Code*,Norms*,Start Date*,End Date\n";
        } else if (isset($_REQUEST['upload_type']) && $_REQUEST['upload_type'] == 's_w_u') {
            $ret = $_objItem->uploadMGBNormsFileState();
            $dataFelds = "State Name*,Classification Code,Product Code*,Norms*,Start Date*,End Date\n";
        } else if (isset($_REQUEST['upload_type']) && $_REQUEST['upload_type'] == 'c_w_u') {
            $ret = $_objItem->uploadMGBNormsFileCity();
            $dataFelds = "City Name*,Classification Code,Product Code*,Norms*,Start Date*,End Date\n";
        } else {
            $ret = $_objItem->uploadMGBNormsFileItem();
            $dataFelds = "Product Code*,Classification Code,Norms*,Start Date*,End Date\n";
        }
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $dataFelds;
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End: Sagar : 18th May 2022 : Import MGB Norms
//Todo Start: Sagar : 1st June 2022 : Import Stock to Salesman
if (isset($_POST['import_stock_to_salesman_csv']) && $_POST['import_stock_to_salesman_csv'] == 'yes') {
    $data = "" . $AliaseUsers['salesman'] . " Code*,Item Code*,Batch No,Stock Volume*,UOM Type (Qty/Cases)*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['salesman'] . "_stock_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_stock_to_salesman']) && $_POST['import_stock_to_salesman'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadSalesmanStockFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['salesman'] . " Code*,Item Code*,Batch No,Stock Volume*,UOM Type (Qty/ Cases)*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End: Sagar : 1st June 2022 : Import Stock to Salesman
//import statewise_minimum_item_price
if (isset($_POST['statewise_item_price_import_csv']) && $_POST['statewise_item_price_import_csv'] == 'yes') {
    $data = "State Name*,Product Code*,Price*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"statewise_item_price_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['statewise_item_price_import']) && $_POST['statewise_item_price_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadStateWiseItemPriceImportFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),State Name*,Product Code*,Price*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo Start : Sagar : 10th June 2022 : Import Salesman & Distributor Mapping
if (isset($_POST['salesman_distributor_mapping_import_csv']) && $_POST['salesman_distributor_mapping_import_csv'] == 'yes') {
    $data = "" . $AliaseUsers['salesman'] . " Code*," . $AliaseUsers['distributor'] . " Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['salesman'] . "_" . $AliaseUsers['distributor'] . "_mapping_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['salesman_distributor_mapping_import']) && $_POST['salesman_distributor_mapping_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadSalesmanDistributorMappingFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sal_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['salesman'] . " Code*," . $AliaseUsers['distributor'] . " Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End : Sagar : 10th June 2022 : Import Salesman & Distributor Mapping
//Todo Start : Sagar : 17th June 2022 : Import Leads
if (isset($_POST['import_leads_csv']) && $_POST['import_leads_csv'] == 'yes') {
    $data = "Title*,Validation Status*,Lead Source*,Lead Status*,Reason,Lead Type,Next Step,Sales Cycle Code,Order Qty,Order Value,Remarks,Landmark,Customer/Organisation Name*,Customer Type,Customer Channel,Customer Mobile No.,Customer Email,State*,District*,City*,Address,Assigned " . $AliaseUsers['salesman'] . " Code,Contact Person Name*,Contact Phone No.*,Contact Email,Contact Designation\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"leads_import_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_leads']) && $_POST['import_leads'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadLeadsFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Title*,Validation Status*,Lead Source*,Lead Status*,Reason,Lead Type,Next Step,Sales Cycle Code,Order Qty,Order Value,Remarks,Customer/Organisation Name*,Customer Type,Customer Channel,Customer Mobile No.,Customer Email,State*,District*,City*,Address,Assigned " . $AliaseUsers['salesman'] . " Code,Contact Person Name*,Contact Phone No.*,Contact Email,Contact Designation\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End : Sagar : 17th June 2022 : Import Leads
//Todo Start : Sagar : 2nd Sep 2022 : Import New Route List
if (isset($_POST['import_new_route_list_csv']) && $_POST['import_new_route_list_csv'] == 'yes') {
    $data = "Customer Type* (" . $AliaseUsers['retailer'] . "/" . $AliaseUsers['distributor'] . "),Customer Code*,".$AliaseUsers['route']." Name*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"new_".$AliaseUsers['route']."_list_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_new_route_list']) && $_POST['import_new_route_list'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadNewRetDistRouteList();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Customer Type* (" . $AliaseUsers['retailer'] . "/" . $AliaseUsers['distributor'] . "),Customer Code*,Route Name* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End : Sagar : 2nd Sep 2022 : Import New Route List
//Todo Start : Sagar : 30th Sep 2022 : Import Item Update Sheet for Name & Prices
if (isset($_POST['import_item_update_csv']) && $_POST['import_item_update_csv'] == 'yes') {
    $data = "Item Code*,Item Description,Brand,Category,Sub Category,Cases Size,Grams,Tax Rate,Item PTR,Item MRP,". $AliaseUsers['distributor'] . "Price,". $AliaseUsers['stockist'] . "Price,Grade,HSN Code,FOC Item(Yes/No)\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"item_update_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_item_update']) && $_POST['import_item_update'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadItemUpdateFile();
      
        if ($ret == '') {
            // $msg = "File has been successfully imported.";
            $_SESSION['gradeSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            //  $error1 = "Empty file";
            $_SESSION['gradeErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            //$error1 = "File format not match.";
            $_SESSION['gradeErr'] = "File format not match.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Item Code*,Item Description,Brand, Category,Sub Category,Cases Size,Grams,Tax Rate,Item PTR,Item MRP," . $AliaseUsers['distributor'] . " Price," . $AliaseUsers['stockist'] . " Price,Grade,HSN Code,FOC Item(Yes/No)\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End : Sagar : 30th Sep 2022 : Import Item Update Sheet for Name & Prices
if (isset($_POST['item_discount_import_csv']) && $_POST['item_discount_import_csv'] == 'yes') {
    $data = "Item Code*,Discount%*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"item_discount_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['item_discount_import']) && $_POST['item_discount_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        //$_objItem->mysql_query("delete from table_color");
        $ret = $_objItem->uploadItemDiscountFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Item Code*,Discount%*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo Start : Sagar : 16th Dec 2022 : Import Retailer & Distributor Mapping
if (isset($_POST['retailer_distributor_mapping_import_csv']) && $_POST['retailer_distributor_mapping_import_csv'] == 'yes') {
    $data = "" . $AliaseUsers['retailer'] . " Code*," . $AliaseUsers['distributor'] . " Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['retailer'] . "_" . $AliaseUsers['distributor'] . "_mapping_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['retailer_distributor_mapping_import']) && $_POST['retailer_distributor_mapping_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerDistributorMappingFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sal_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " Code*," . $AliaseUsers['distributor'] . " Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End : Sagar : 16th Dec 2022 : Import Retailer & Distributor Mapping
//Todo Start:Sagar : 4th Jan 2023 : Import Retailer Type Wise Item Price
if (isset($_POST['ret_type_item_price_import_csv']) && $_POST['ret_type_item_price_import_csv'] == 'yes') {
    $data = "Item Code*," . $AliaseUsers['retailer'] . " Type*,Price*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"price_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['ret_type_item_price_import']) && $_POST['ret_type_item_price_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerTypeItemPriceFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Item Code*," . $AliaseUsers['retailer'] . " Type*,Price*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End:Sagar : 4th Jan 2023 : Import Retailer Type Wise Item Price
/* * *******************************CSV For DIS Credit/Debit Invoices  ********************************** */
if (isset($_POST['dis_credit_debit_invoice_import_csv']) && $_POST['dis_credit_debit_invoice_import_csv'] == 'yes') {
    $data = "Distributor Code*,Stockist Code*,Voucher No,Date*,Amount*,Invoice Type(Credit|Debit)*,Remarks,Invoice By(Pepup)*,Reason*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"import_dis_credit_debit_invoice.csv\"");
    echo $data;
    die;
}
if (isset($_POST['dis_credit_debit_invoice_import']) && $_POST['dis_credit_debit_invoice_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDisCreditDebitInvoices();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Distributor Code*,Stockist Code*,Voucher No,Date*,Amount*,Invoice Type(Credit|Debit)*,Remarks,Invoice By*(Pepup),Reason*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;

            die;
        }
    }
}
/* * **************************** CSV For DIS Credit/Debit Invoices********************************** */
//Todo Start:Sagar : 5th Jan 2023 : Import Distributor Type Wise Item Price
if (isset($_POST['dist_type_item_price_import_csv']) && $_POST['dist_type_item_price_import_csv'] == 'yes') {
    $data = "Item Code*," . $AliaseUsers['distributor'] . " Type*,Price*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"price_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['dist_type_item_price_import']) && $_POST['dist_type_item_price_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDistributorTypeItemPriceFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Item Code*," . $AliaseUsers['distributor'] . "  Type*,Price*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End:Sagar : 5th Jan 2023 : Import Distributor Type Wise Item Price
//Todo Start :Jatin : 15 Feb 2023 : Import Salesman Mapping with multiple category
if (isset($_POST['salesman_category_import_csv']) && $_POST['salesman_category_import_csv'] == 'yes') {
    $data = "" . $AliaseUsers['salesman'] . " Code* , Category Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['salesman'] . "_mapping_Category.csv\"");
    echo $data;
    die;
}
if (isset($_POST['salesman_import_category']) && $_POST['salesman_import_category'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadNewSalCategoryList();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sal_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['salesman'] . " Code* , Category Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End : Jatin : 15 Feb 2023 : Import Salesman Mapping with multiple category
//Todo Start : Jatin : 9th March 2023 : Import Salesman State District City mapping
if (isset($_POST['state_dist_city_salesman_mapping_import_csv']) && $_POST['state_dist_city_salesman_mapping_import_csv'] ==
    'yes') {
    $data = "" . $AliaseUsers['salesman'] . " Code*, State Name* , District Name* , City Name*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['salesman'] . "_state_dist_city_mapping_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['state_dist_city_salesman_mapping_import']) && $_POST['state_dist_city_salesman_mapping_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadSalesmanCombinationMappingFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sal_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['salesman'] . " Code*, State Name , District Name ,City Name\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End : Jatin : 9th March 2023 : Import Salesman State District City mapping
//Todo Start : Jatin : 15th March 2023 : Import Distributor wise item Price
if (isset($_POST['distributor_wise_item_price_import_csv']) && $_POST['distributor_wise_item_price_import_csv'] == 'yes') {
    $data = "" . $AliaseUsers['distributor'] . " Code*,Item Code*,Price*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['distributor'] . "_wise_item_price_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['distributor_wise_item_price_import']) && $_POST['distributor_wise_item_price_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDistributorWiseItemPriceFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['distributor'] . " Code*,Item Code*,Price*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End : Jatin : 15th March 2023 : Import Distributor wise item Price
//Todo End : Jatin : 16th March 2023 : Import Distributor State wise item Price
if (isset($_POST['distributor_state_wise_item_price_import_csv']) && $_POST['distributor_state_wise_item_price_import_csv'] ==
    'yes') {
    $data = "" . $AliaseUsers['distributor'] . " State Name*,Item Code*,Price*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['distributor'] . "_state_wise_item_price_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['distributor_state_wise_item_price_import']) && $_POST['distributor_state_wise_item_price_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadStateWiseDisItemPriceImportFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['distributor'] . " State Name*,Item Code*,Price*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End : Jatin : 16th March 2023 : Import Distributor State wise item Price
//Todo Start : Jatin : 18 April 2023: Import Retailer Wise Item Code
if (isset($_POST['ret_wise_item_code_import_csv']) && $_POST['ret_wise_item_code_import_csv'] == 'yes') {
    $data = $AliaseUsers['retailer'] . " Code*, Item Code* ," . $AliaseUsers['retailer'] . " Item Code *\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\" " . $AliaseUsers['retailer'] . "_Item_code_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['ret_wise_item_code_import']) && $_POST['ret_wise_item_code_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerItmCodeFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " Code*, Item Code*,"
                . $AliaseUsers['retailer'] . " Item Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
// Todo End : Jatin : 18 April 2023: Import Retailer Wise Item Code
// Todo Start : Jatin : 6 May 2023 : Import target report
if (isset($_POST['target_import_csv']) && $_POST['target_import_csv'] == 'yes') {
    $data = "Target Name*," . $AliaseUsers['salesman'] . " Code* , Month*, Year*, Amount* \n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Secondary_Target_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['target_csv_import']) && $_POST['target_csv_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadTargetFile();
        if ($ret == '') {
            $msg = "Targets has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Target Name , " . $AliaseUsers['salesman'] . " Code , Month , Year , Amount  \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
// Todo End : Jatin : 6 May 2023 : Import target report
// Todo Start : Jatin : 6 May 2023 : Import tertiary target report
if (isset($_POST['target_tertiary_import_csv']) && $_POST['target_tertiary_import_csv'] == 'yes') {
    $data = "Target Name*, " . $AliaseUsers['salesman'] . " Code* , Month*, Year*, Amount*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Tertiary_Target_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['target_tertiary_csv_import']) && $_POST['target_tertiary_csv_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadTertiaryTargetFile();
        if ($ret == '') {
            $msg = "Data has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Target Name," . $AliaseUsers['salesman'] . " Code , Month , Year , Amount  \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
// Todo End : Jatin : 6 May 2023 : Import tertiary target report
//Todo Start : Jatin : 19 May 2023: Import Retailer Type Wise Item Code
if (isset($_POST['ret_type_wise_item_code_import_csv']) && $_POST['ret_type_wise_item_code_import_csv'] == 'yes') {
    $data = $AliaseUsers['retailer'] . " Type*, Item Code* ," . $AliaseUsers['retailer'] . " Type Item Code *\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\" " . $AliaseUsers['retailer'] . "_Type_Wise_Item_code_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['ret_type_wise_item_code_import']) && $_POST['ret_type_wise_item_code_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailertypeWiseItmCodeFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " Type*, Item Code*,"
                . $AliaseUsers['retailer'] . " Type Item Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
// Todo End : Jatin : 19 May 2023: Import Retailer Type Wise Item Code
// Todo Start : Sudhanshu
/*******************Distributor order bulk upload *************************/
if (isset($_REQUEST['distributor_order_bulk_upload_csv']) && $_REQUEST['distributor_order_bulk_upload_csv'] == 'yes') {
    $data = "Item Code*, Quantity*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"distributor_order_bulk_upload_csv.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_distributor_bulk_order']) && $_POST['import_distributor_bulk_order'] == 'yes') {
    //echo "hii";die;
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->distributorBulkOrder($_POST);
        if (is_array($ret) && count($ret) > 0) {
            $data2 = "Item Code , Quantity , Error\n";
            for ($i = 0; $i < count($ret); $i++) {
                $data2 .= '"' . $ret[$i]['item_code'] . '"';
                $data2 .= ",";
                $data2 .= '"' . $ret[$i]['qty'] . '"';
                $data2 .= ",";
                if (count($ret[$i]['msg']) > 1) {
                    foreach ($ret[$i]['msg'] as $j => $val) {
                        $data2 .= '"' . $ret[$i]['msg'][$j] . '"';
                        $data2 .= ",";
                    }
                    $data2 .= "\n";
                } else {
                    $data2 .= '"' . $ret[$i]['msg'] . '"';
                    $data2 .= "\n";
                }
            }
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error'" . date('Y-m-d') . "'.csv\"");
            echo $data2;
            die;
        } elseif ($ret == 1) {
            $_SESSION['dsus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == "no") {
            $_SESSION['cat_err'] = "File Format Not Matched .";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $_SESSION['cat_err'] = "Empty File.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        }
        if ($error1 != '') {
            $_SESSION['cat_err'] = $error1;
            // header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $data = "Item Code*, Quantity\n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"distributor_order_bulk_upload_csv.csv\"");
            echo $data;
            die;
        }
    }
}
if (isset($_REQUEST['retailer_order_bulk_upload_csv']) && $_REQUEST['retailer_order_bulk_upload_csv'] == 'yes') {
    $data = "Retailer Code*, Item Code*, Quantity*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"retailer_order_bulk_upload_csv.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_retailer_bulk_order']) && $_POST['import_retailer_bulk_order'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
//        $ret = $_objItem->retailerBulkOrder($_POST);
        $ret = $_objItem->uploadRetailerBulkupload($_POST);
        if (is_array($ret) && count($ret) > 0) {
            $data2 = "Retailer Code* , Item Code* , Quantity* , Error\n";
            foreach ($ret as $erKey => $erVal) {
                foreach ($erVal as $iKey => $iVal) {
                    if (count($iVal) > 1) {
                        $data2 .= '"' . $erKey . '"';
                        $data2 .= ",";
                        $data2 .= '"' . $iVal['item_code'] . '"';
                        $data2 .= ",";
                        $data2 .= '"' . $iVal['qty'] . '"';
                        $data2 .= ",";
                        if (count($iVal['err_msg']) > 1) {
                            foreach ($iVal['err_msg'] as $j => $val) {
                                $data2 .= '"' . $iVal['err_msg'][$j] . '"';
                                $data2 .= ",";
                            }
                            $data2 .= "\n";
                        } else {
                            $data2 .= '"' . $iVal['err_msg'] . '"';
                            $data2 .= "\n";
                        }
                    }
                }
                $data2 .= '"' . $erVal['ret_code'] . '"';
                $data2 .= ",";
                $data2 .= '"' . $erVal['item_code'] . '"';
                $data2 .= ",";
                $data2 .= '"' . $erVal['qty'] . '"';
                $data2 .= ",";
                $data2 .= '"' . $erVal['err_msg'] . '"';
                $data2 .= "\n";
            }
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error-" . date('Y-m-d') . ".csv\"");
            echo $data2;
            die;
        } elseif ($ret == 1) {
            $_SESSION['msg'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == "no") {
            $_SESSION['ermsg'] = "File Format  Not Matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $_SESSION['ermsg'] = "Empty file.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
            $error1 = $ret;
        }
        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Retailer Code*, Item Code*, Quantity*\n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"retailer_order_bulk_upload_csv.csv\"");
            echo $data;
            die;
        }
    }
}// Todo End : Sudhanshu
// customer wise routes schedules 16 aug 2023
if (isset($_POST['customer_wise_route_assignment_import_csv']) && $_POST['customer_wise_route_assignment_import_csv'] == 'yes') {
    $data = "Retailer Code*," . $AliaseUsers['salesman'] . " Code*,Assign Day*(Mon|Tue|Wed|Thu|Fri|Sat|Sun),From Date* (yyyy-mm-dd),To Date* (yyyy-mm-dd)\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"customer_wise_".$AliaseUsers['route']."_list_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['customer_wise_route_import_days']) && $_POST['customer_wise_route_import_days'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadCustomerWiseRouteList($salesman);
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            //   $_SESSION['dsus'] = $msg;
            $_SESSION['dsus'] = $msg;
            // echo basename($_SERVER['PHP_SELF']);die;
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;
        } elseif ($error1 != '') {
            $cat_err = $error1;
            $_SESSION['errrr'] = $error1;
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;
        } else {
            // $data="Row Number(Please Delete The Row When Import),".$AliaseUsers['salesman']." Name*, Route Name*, Year* ,Month*, \n";
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " Code*," . $AliaseUsers['salesman'] . " Code*,Assign Day*(Mon|Tue|Wed|Thu|Fri|Sat|Sun),From Date* (yyyy-mm-dd),To Date* (yyyy-mm-dd)\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/*********************** Ends Import Customer wise Route Assignment ***********************/
//Todo Start: Sudhanshu: 06 Sept 2023: import CSV For Grades
if (isset($_REQUEST['grade_import_csv']) && $_REQUEST['grade_import_csv'] == 'yes') {
    $data = "Grades Name*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"grades_sheet.csv\"");
    echo $data;
    die;
}
//Todo Start: Sudhanshu: 06 Sep 2023: import CSV For Grades
if (isset($_POST['grade_import']) && $_POST['grade_import'] == 'yes') {
    // echo "hii";die;
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadGrades();
        if ($ret == '') {
            // $msg = "File has been successfully imported.";
            $_SESSION['gradeSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            //  $error1 = "Empty file";
            $_SESSION['gradeErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            //$error1 = "File format not match.";
            $_SESSION['gradeErr'] = "File format not match.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Grade Name* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo END: Sudhanshu: 06 Sep 2023: import CSV For Grades
if (isset($_POST['item_import_csv']) && $_POST['item_import_csv'] == 'yes') {
    //$data="Category Name*,Item Code*,Item Description*,Size,D.P*,M R P*,Colors Code, Item Chain\n";
//    $data = "Category Name*,Item Code*,Item Description*,Grams,D.P,M R P*,Cases Size*,Brand*,Item Erp Code,Variant Name,Sku Name,Tax Rate,Distributor Price,Stockist Price\n";
//    $data = "Category Name*,Item Code*,Item Description*,Grams,Item MRP,Item PTR*,Cases Size*,Brand*,Item Erp Code,Variant Name,Sku Name,Tax Rate,".$AliaseUsers['distributor']." Price,".$AliaseUsers['stockist']." Price\n";
    $data = "Item Code*,Item Description*, Brand*,Category Name*,Sub Category, Cases Size*,Grams,Tax Rate,Item MRP,Item PTR*," . $AliaseUsers['distributor'] . " Price," . $AliaseUsers['stockist'] . " Price, Grade Name";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"item_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['item_import']) && $_POST['item_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadItemListFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Item Code*,Item Description*, Brand*,Category Name*,Sub Category, Cases Size*,Grams,Tax Rate,Item MRP,Item PTR*," . $AliaseUsers['distributor'] . " Price," . $AliaseUsers['stockist'] . " Price, Grade Name,HSN Code\n";

            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo Start: Sudhanshu: 07 Sept 2023: import CSV For Retailer Group
if (isset($_REQUEST['retailer_group_import_csv']) && $_REQUEST['retailer_group_import_csv'] == 'yes') {
    $data = "Group Name*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"retailer_group_sheet.csv\"");
    echo $data;
    die;
}
//Todo Start: Sudhanshu: 07 Sep 2023: import CSV For Retailer Group
if (isset($_POST['retailer_group_import']) && $_POST['retailer_group_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerGroup();
        if ($ret == '') {
            //$msg = "File has been successfully imported.";
            $_SESSION['groupSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            //  $error1 = "Empty file";
            $_SESSION['groupErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            //  $error1 = "File formate not match";
            $_SESSION['groupErr'] = "File format not match.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Group Name* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo END: Sudhanshu: 07 Sep 2023: import CSV For Retailer Group
//Todo Start: Sudhanshu: 07 Sept 2023: import CSV For Retailer Group
if (isset($_REQUEST['purpose_visit_import_csv']) && $_REQUEST['purpose_visit_import_csv'] == 'yes') {
    $data = "Purpose of Visit*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"purpose_visit_sheet.csv\"");
    echo $data;
    die;
}
//Todo Start: Sudhanshu: 13 Sep 2023: import CSV For Purpose of Visit
if (isset($_POST['purpose_visit_import']) && $_POST['purpose_visit_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadPurposeVisit();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Purpose of Visit* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo Start: Sudhanshu: 13 Oct 2023: import CSV For rsurvey and salesman mapping import
if (isset($_REQUEST['survey_saleman_mapping_csv']) && $_REQUEST['survey_saleman_mapping_csv'] == 'yes') {
    $data = "Survey Code*, Salesman Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"survey_salesman_mapping.csv\"");
    echo $data;
    die;
}
if (isset($_POST['survey_saleman_mapping_import']) && $_POST['survey_saleman_mapping_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadSurveySalesmanMapping();
        if ($ret == '') {
            $_SESSION['surSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            $_SESSION['surErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            $_SESSION['surErr'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Survey Code*, Salesman Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo Start: Sudhanshu: 13 Oct 2023: import CSV For rsurvey and salesman mapping UPDATE
if (isset($_POST['survey_saleman_mapping_import_update']) && $_POST['survey_saleman_mapping_import_update'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadSurveySalesmanMappingUpdate();
        if ($ret == '') {
            $_SESSION['surSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            $_SESSION['surErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            $_SESSION['surErr'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Survey Code*, Salesman Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
// Todo Start : batch master import : sudhanshu : 25  oct 2023
if (isset($_REQUEST['batch_import_csv']) && $_REQUEST['batch_import_csv'] == 'yes') {
    $data = "Batch Code,Batch Number*,MFG Date (dd-mm-yyyy),Expiry Date (dd-mm-yyyy)\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"batch_import_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['batch_import']) && $_POST['batch_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadBatch();
        if ($ret == '') {
            $_SESSION['batch_sus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            $_SESSION['batch_err'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            $_SESSION['batch_err'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Batch Code, Batch Number*,MFG Date,Expiry Date \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
// Todo End : batch master import : sudhanshu : 25  oct 2023
// Todo Start : Item & batch master import : sudhanshu : 25  oct 2023
if (isset($_REQUEST['item_batch_import_csv']) && $_REQUEST['item_batch_import_csv'] == 'yes') {
    $data = "Batch Code*,Item Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"item_batch_mapping_import_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['item_batch_import']) && $_POST['item_batch_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadItemBatchMapping();
        if ($ret == '') {
            $_SESSION['batch_sus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            $_SESSION['batch_err'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            $_SESSION['batch_err'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Batch Code*,Item Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
// Todo End : Item & batch master import : sudhanshu : 25  oct 2023
//Todo Start: Sudhanshu: 12 Oct 2023: import CSV For Retailer class Import
if (isset($_REQUEST['relationship_import_csv']) && $_REQUEST['relationship_import_csv'] == 'yes') {
    $data = "Retailer Class*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"retailer_class_import_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['relationship_import']) && $_POST['relationship_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRelationshp();
        if ($ret == '') {
            $_SESSION['relSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            $_SESSION['relErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            $_SESSION['relErr'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Retailer Class*,Error \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End: Sudhanshu: 12 Oct 2023: import CSV For Retailer class Import
//Todo Start: Sudhanshu: 12 Oct 2023: import CSV For retailer channel import
if (isset($_REQUEST['retailer_channel_import_csv']) && $_REQUEST['retailer_channel_import_csv'] == 'yes') {
    $data = "Retailer Channel*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"retailer_channel_import_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['retailer_channel_import']) && $_POST['retailer_channel_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerChannel();
        if ($ret == '') {
            $_SESSION['chanlSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            $_SESSION['chanlErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            $_SESSION['chanlErr'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Retailer Channel*,Error \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End: Sudhanshu: 12 Oct 2023: import CSV For retailer channel import
// Todo Start :  Sudhanshu : retailer type master import
if (isset($_REQUEST['retailer_type_import_csv']) && $_REQUEST['retailer_type_import_csv'] == 'yes') {
    $data = "Retailer Type*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"retailer_type_import_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['retailer_type_import']) && $_POST['retailer_type_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerType();
        if ($ret == '') {
            $_SESSION['typeSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            $_SESSION['typeErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            $_SESSION['typeErr'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Retailer Type* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}

// Todo Start :  geeta code : retailer status master import

if (isset($_POST['retailer_statusimport_update_csv']) && $_POST['retailer_statusimport_update_csv'] == 'yes') {
    //
    //    $data = "" . $AliaseUsers['retailer'] . " Name*,Phone No1*,Phone No2," . $AliaseUsers['retailer'] . " Address," . $AliaseUsers['retailer'] . " Market*,State*,District*,City*,Zipcode,Contact Person1*,contact Phone No1* ,Contact Person2,Contact Phone No2,Email-ID1*,Email-ID2," . $AliaseUsers['retailer'] . " Class, Route Name," . $AliaseUsers['retailer'] . " Channel," . $AliaseUsers['distributor'] . " Code*,Display Outlet," . $AliaseUsers['retailer'] . " Type,Username,Password,GST Number,PAN Number," . $AliaseUsers['retailer'] . " Code,Aadhar Number\n";
    $data = "" . $AliaseUsers['retailer'] . " Code*,Retailer Status\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['retailer'] . "_status_update_sheet.csv\"");
    echo $data;
    die;
}
// geeta code
if (isset($_REQUEST['retailer_schemeimport_update_csv'])) {
    //
    //    $data = "" . $AliaseUsers['retailer'] . " Name*,Phone No1*,Phone No2," . $AliaseUsers['retailer'] . " Address," . $AliaseUsers['retailer'] . " Market*,State*,District*,City*,Zipcode,Contact Person1*,contact Phone No1* ,Contact Person2,Contact Phone No2,Email-ID1*,Email-ID2," . $AliaseUsers['retailer'] . " Class, Route Name," . $AliaseUsers['retailer'] . " Channel," . $AliaseUsers['distributor'] . " Code*,Display Outlet," . $AliaseUsers['retailer'] . " Type,Username,Password,GST Number,PAN Number," . $AliaseUsers['retailer'] . " Code,Aadhar Number\n";
    $data = "" . $AliaseUsers['retailer'] . " Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['retailer'] . "_sheet.csv\"");
    echo $data;
    die;
}
//geeta end code
if (isset($_POST['retailer_statusimport_update']) && $_POST['retailer_statusimport_update'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerStatusUpdateFile();
        //print_r($ret);die;
        if ($ret == '') {
            $msg = "Status has been successfully updated";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $ret_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " Code*,Retailer Status\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
// geeta code

if (isset($_POST['retailer_schemewiseimport_update']) && $_POST['retailer_schemewiseimport_update'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {

        $file = fopen($_FILES['fileToUpload']['tmp_name'], "r");
        $numrows    = 0;

    while (($data = fgetcsv($file, 0)) !== FALSE) {
        $numrows++;
    }
     
    if($numrows>2000){
        $ret="Kindly upload 2k records at a time";
        $msg = "Kindly upload 2k records at a time";
        header('Refresh: 2;');
      
    }else{
        $ret = $_objItem->uploadschemeretailerFile($_POST['discountid']);
    }
     //   print_r($ret);die;
        if ($ret == '') {
            $msg = "Retailer successfully updated";
            header('Refresh: 1;');
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $ret_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $step = "nextStep";
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " Code*,Retailer Status\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            
           
            echo $data;
           
          
           die;
        }
    }
}
if (isset($_POST['retailer_wiseimport_update']) && $_POST['retailer_wiseimport_update'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {

        $uploadedfile = fopen($_FILES['fileToUpload']['tmp_name'], "r");
        $numrows    = 0;

    while (($data = fgetcsv($uploadedfile, 0)) !== FALSE) {
        $numrows++;
    }
    
    if($numrows>2000){
        $msg = "Kindly upload 2k records at a time";
        $data = array(
            "msg"     => 'failure',
            "data"  => '',
            "errordata"  => '',
            "isrefresh"  => $isrefresh
        );
        echo json_encode($data); die;
    }
        $isrefresh='no';
        $ret = $_objItem->retailerStatusUpdateFile($_POST['discountid']);
      
        if(count($ret['data'])>0){
        $datalist = implode(",", $ret['data']);
 
       
        }else{
            $datalist = '';
        }
       
        $_SESSION['datalist']=$datalist;
        $datalistencoded= array_chunk($ret['data'], 500);
       

        if ($ret['status'] == 'success') {
          
           
            $msg = "Status has been successfully updated";
            $data = array(
                "msg"     => 'success',
                "data"  => $datalistencoded[0],
                "errordata"  => '',
                "isrefresh"  => $isrefresh
            );
            echo json_encode($data);
         //   echo $datalist;
        }else{ 
            
            if ($ret['data'] == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret['errordata']);
        }
    }
        if ($msg != '') {
            $ret_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
          //  $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " Code*,Retailer Status\n";
        
        
         //print_r($data); die;
       
            $data = array(
                "msg"     => 'error',
                "errordata"  => $error,
                "data"  => $datalistencoded[0],
             //   "data2"  => $data[1],
               // "data3"  => $data[2],
                //"data4"  => $data[3],
                "isrefresh"  => 'no'
            );
            echo json_encode($data);
          
            die;
        }
    }
}
// end geeta code
// Todo Start :  Sudhanshu : retailer type master import
/************************************* CSV For Retailer Update : sudhanshu : 14 Nov 2023 ***************************************/
if (isset($_POST['retailer_import_update_csv']) && $_POST['retailer_import_update_csv'] == 'yes') {
    //
    //    $data = "" . $AliaseUsers['retailer'] . " Name*,Phone No1*,Phone No2," . $AliaseUsers['retailer'] . " Address," . $AliaseUsers['retailer'] . " Market*,State*,District*,City*,Zipcode,Contact Person1*,contact Phone No1* ,Contact Person2,Contact Phone No2,Email-ID1*,Email-ID2," . $AliaseUsers['retailer'] . " Class, Route Name," . $AliaseUsers['retailer'] . " Channel," . $AliaseUsers['distributor'] . " Code*,Display Outlet," . $AliaseUsers['retailer'] . " Type,Username,Password,GST Number,PAN Number," . $AliaseUsers['retailer'] . " Code,Aadhar Number\n";
    $data = "" . $AliaseUsers['retailer'] . " Code*," . $AliaseUsers['retailer'] . " Name,Phone No1,Phone No2,State,District,City," . $AliaseUsers['retailer'] . " Market,Zipcode," . $AliaseUsers['retailer'] . " Address," . $AliaseUsers['retailer'] . " Class," . $AliaseUsers['retailer'] . " Channel," . $AliaseUsers['retailer'] . " Type,GST Number, PAN Number,Aadhar Number,Display Outlet,Contact Person1,contact Phone No1 ,Email-ID1,Contact Person2,Contact Phone No2,Email-ID2, " . $AliaseUsers['distributor'] . " Code, " . $AliaseUsers['retailer'] . " Group,Username,Password\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['retailer'] . "_update_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['retailer_import_update']) && $_POST['retailer_import_update'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerUpdateFile();
        //print_r($ret);die;
        if ($ret == '') {
            $msg = "Data has been successfully imported";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $ret_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " Code*," . $AliaseUsers['retailer'] . " Name,Phone No1,Phone No2,State,District,City," . $AliaseUsers['retailer'] . " Market,Zipcode," . $AliaseUsers['retailer'] . " Address," . $AliaseUsers['retailer'] . " Class," . $AliaseUsers['retailer'] . " Channel," . $AliaseUsers['retailer'] . " Type,GST Number, PAN Number,Aadhar Number,Display Outlet,Contact Person1,contact Phone No1 ,Email-ID1,Contact Person2,Contact Phone No2,Email-ID2, " . $AliaseUsers['distributor'] . " Code, " . $AliaseUsers['retailer'] . " Group,Username,Password\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
// Todo start : sudhanshu :05 dec 2023 : distributor order upload
if (isset($_REQUEST['distributor_order_upload_csv']) && $_REQUEST['distributor_order_upload_csv'] == 'yes') {
    $data = "Item Code,Item Code*, Quantity*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"distributor_order_upload_csv.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_distributor_order']) && $_POST['import_distributor_order'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->distributorOrderUpload($_POST);
        if (is_array($ret) && count($ret) > 0) {
            $data2 = "Item Name, Item Code , Quantity , Error\n";
            for ($i = 0; $i < count($ret); $i++) {
                $data2 .= '"' . $ret[$i]['item_name'] . '"';
                $data2 .= ",";
                $data2 .= '"' . $ret[$i]['item_code'] . '"';
                $data2 .= ",";
                $data2 .= '"' . $ret[$i]['qty'] . '"';
                $data2 .= ",";
                if (count($ret[$i]['msg']) > 1) {
                    foreach ($ret[$i]['msg'] as $j => $val) {
                        $data2 .= '"' . $ret[$i]['msg'][$j] . '"';
                        $data2 .= ",";
                    }
                    $data2 .= "\n";
                } else {
                    $data2 .= '"' . $ret[$i]['msg'] . '"';
                    $data2 .= "\n";
                }
            }
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error'" . date('Y-m-d') . "'.csv\"");
            echo $data2;
            die;
        } elseif ($ret == 1) {
            $_SESSION['dsus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == "no") {
            $_SESSION['cat_err'] = "File Format Not Matched .";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $_SESSION['cat_err'] = "Empty File.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        }
        if ($error1 != '') {
            $_SESSION['cat_err'] = $error1;
            // header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $data = "Item Code*, Quantity\n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"distributor_order_bulk_upload_csv.csv\"");
            echo $data;
            die;
        }
    }
}
// Todo End : sudhanshu :05 dec 2023 : distributor order upload
//Todo Start :sudhanshu : 07 dec 2023 distributor wise item description
if (isset($_POST['dis_wise_item_desc_import_csv']) && $_POST['dis_wise_item_desc_import_csv'] == 'yes') {
    $data = " Item Code* ," . $AliaseUsers['distributor'] . " Code*, Item Description*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\" " . $AliaseUsers['distributor'] . "_Wise_Item_description_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['dis_wise_item_desc_import']) && $_POST['dis_wise_item_desc_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDisWisItemDescFile();
        if ($ret == '') {
            $_SESSION['dis_sus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
            $_SESSION['dis_err'] = "Empty file.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;
        } elseif ($ret == 'fnot') {
            $_SESSION['dis_err'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import), Item Code*," . $AliaseUsers['distributor'] . " Code, Item Description\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
// Todo End : sudhanshu : 07 dec 2023 distributor wise item description
/*******************Dist order bulk upload function-1*********************************************************/
if (isset($_POST['import_distributor_bulk_order_dynamic']) && $_POST['import_distributor_bulk_order_dynamic'] == 'yes') {
    //echo "<pre>";print_r($_POST);die;
    $_SESSION['order_type'] = $_POST['order_type'];
    $_SESSION['reason'] = $_POST['reason'];
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $OdrUploadOpt1 = $_objItem->distributorBulkOrderDynamic($_POST);
        if ($OdrUploadOpt1 == 'no') {
            $_SESSION['cat_err'] = "Header Can't be Empty";
        } else {
            foreach ($OdrUploadOpt1 as $key => $value) {
                $keylen[] = $key;
                if (!empty($value)) {
                    $vallen[] = $value;
                }
            }
            if (sizeof($keylen) == sizeof($vallen)) {
                $OdrUploadOpt = $OdrUploadOpt1;
            } else {
                $_SESSION['cat_err'] = "Header Cant' be Blank. Kindly Check the Imported Sheet";
            }
        }
    }
}
// Todo : Start : Jatin : 18 Dec 2023 Distributor bulk upload order New
if (isset($_POST['import_distributor_bulk_order_new']) && $_POST['import_distributor_bulk_order_new'] == 'yes') {
    $ret = $_objItem->distributorBulkOrdernew($_POST);
    if (is_array($ret) && count($ret) > 0) {
        $data2 = "Item Code , Item Name , Quantity , Error\n";
        for ($i = 0; $i < count($ret); $i++) {
            $data2 .= '"' . $ret[$i]['item_code'] . '"';
            $data2 .= ",";
            $data2 .= '"' . $ret[$i]['item_name'] . '"';
            $data2 .= ",";
            $data2 .= '"' . $ret[$i]['qty'] . '"';
            $data2 .= ",";
            if (count($ret[$i]['msg']) > 1) {
                foreach ($ret[$i]['msg'] as $j => $val) {
                    $data2 .= '"' . $ret[$i]['msg'][$j] . '"';
                    $data2 .= ",";
                }
                $data2 .= "\n";
            } else {
                $data2 .= '"' . $ret[$i]['msg'] . '"';
                $data2 .= "\n";
            }
        }
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"error'" . date('Y-m-d') . "'.csv\"");
        echo $data2;
        die;
    } elseif ($ret == 1) {
        $_SESSION['dsus'] = "File has been successfully imported.";
        header('Location:distributor_order_bulk_upload_new.php');
    } elseif ($ret == "no") {
        $_SESSION['cat_err'] = "File Format Not Matched .";
        header('Location:' . basename($_SERVER['PHP_SELF']));
    } else {
        $_SESSION['cat_err'] = "Empty File.";
        header('Location:' . basename($_SERVER['PHP_SELF']));
    }
    if ($error1 != '') {
        $_SESSION['cat_err'] = $error1;
        // header('Location:' . basename($_SERVER['PHP_SELF']));
    } else {
        $data = "Item Code*, Quantity\n";
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"distributor_order_bulk_upload_csv.csv\"");
        echo $data;
        die;
    }
}
// Todo : End : Jatin : 18 Dec 2023 Distributor bulk upload order New
// Todo : Start : Jatin : 20 Dec 2023 : Replica csv xls and xlxs extension read file
if (isset($_POST['import_distributor_bulk_order_dynamic_replica']) && $_POST['import_distributor_bulk_order_dynamic_replica'] ==
    'yes') {
    echo "<pre>";
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $OdrUploadOpt = $_objItem->distributorBulkOrderDynamicreplica($_POST);
        print_r($OdrUploadOpt);
        die;
    }
}
// Todo : End : Jatin : 20 Dec 2023 : Replica csv xls and xlxs extension read file
// Todo Start : sudhanshu : 19 dec 2023 salesman bulk update
if (isset($_POST['salesman_import_update_csv']) && $_POST['salesman_import_update_csv'] == 'yes') {
    //    $data = "".$AliaseUsers['salesman']." Name*,State*,District*,City*,Address,Phone No*,Username,Password,Category Name,".$AliaseUsers['salesman']." Designation,Reporting Person,Min Price Editable (Yes/No),".$AliaseUsers['salesman']." Code\n";
    $data = "" . $AliaseUsers['salesman'] . " Code*," . $AliaseUsers['salesman'] . " Name, Phone No, Email Id,State, District, City, Address, Reporting Person,Username, Password ,Min Price Editable (Yes/No), Joining Date(mm-dd-yyyy), Salary";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['salesman'] . "_update_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['salesman_import_update']) && $_POST['salesman_import_update'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadSalesmanUpdateFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
            $_SESSION['sal_sus'] = "Data has been successfully imported";
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;
        } elseif ($ret == 'no') {
            $_SESSION['sal_err'] = "Empty File.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;


        } elseif ($ret == 'fnot') {
            $_SESSION['sal_err'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $sal_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            //            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['salesman'] . " Name*,State*,District*,City*,Address,Phone No*,Username,Password,Category Name," . $AliaseUsers['salesman'] . " Designation,Reporting Person,Min Price Editable (Yes/No)," . $AliaseUsers['salesman'] . " Code\n";

            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['salesman'] . " Code*," . $AliaseUsers['salesman'] . " Name, Phone No, Email Id,State, District, City, Address, Reporting Person,Username, Password ,Min Price Editable (Yes/No),Joining Date(YYYY-MM-DD), Salary\n";

            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
// Todo End : sudhanshu : 19 dec 2023 salesman bulk update
/************************************* CSV For Distributor ***************************************/
if (isset($_POST['import_update_distributor_csv']) && $_POST['import_update_distributor_csv'] == 'yes') {
    $data = "" . $AliaseUsers['distributor'] . " Code*," . $AliaseUsers['distributor'] . " Name,Phone No1," . $AliaseUsers['distributor'] . " Address,zipcode,State,District,City,Contact Person1,contact Phone No1,Email-ID1," . $AliaseUsers['distributor'] . " Type," . $AliaseUsers['stockist'] . " Code,GST No,Username,Password\n";

    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $AliaseUsers['distributor'] . "_update_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_update_distributor']) && $_POST['import_update_distributor'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDistributorUpdateFile();
        if ($ret == '') {
            $_SESSION['dis_sus'] = "Data has been successfully imported";
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;
        } elseif ($ret == 'no') {
            $_SESSION['dis_err'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;
        } elseif ($ret == 'fnot') {
            $_SESSION['dis_err'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $dis_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['distributor'] . " Code*," . $AliaseUsers['distributor'] . " Name,Phone No1," . $AliaseUsers['distributor'] . " Address,zipcode,State,District,City,Contact Person1,contact Phone No1,Email-ID1," . $AliaseUsers['distributor'] . " Type," . $AliaseUsers['stockist'] . " Code,GST No,Username,Password\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
/************************************* CSV For Distributor ***************************************/
/*****************Schemes Bulk Upload Functionality******************************/
/***
 * Created By : Sachin Verma
 * Created On : 15th Jan 2024
 ***/
/************************************* Import Qty Based Schemes Start ***************************************/
if (isset($_REQUEST['qty_based_percentage_benefit_csv']) && $_REQUEST['qty_based_percentage_benefit_csv'] == 'yes') {

    $data = "Scheme Description*,Item Code*,Minimum Qty*,Benefit %*,From Date(Y-m-d)*,To Date(Y-m-d)* \n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Qty_based_percentage_benefit_csv.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_qty_based_percentage_benefit_csv']) && $_POST['import_qty_based_percentage_benefit_csv'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->importQTYandPercentBenefitSchemeFile();
        if ($ret == '') {
            $sus = "Scheme has been added successfully.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($sus != '') {
            $sus = $sus;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Scheme Description*,Item Code*,Minimum Qty*,Benefit %*,From Date*,To Date* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }

}
/************************************* Import Qty Based Schemes End***************************************/
/********************************************************************************/

// Todo : Start : Jatin : 2 Feb 2024 : Parent Salesman mapping

if (isset($_REQUEST['parent_master_csv']) && $_REQUEST['parent_master_csv'] == 'yes') {
    $data = "Parent Code*, Salesman Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Parent_salesman_mapping.csv\"");
    echo $data;
    die;
}
if (isset($_POST['parent_saleman_mapping_import']) && $_POST['parent_saleman_mapping_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadParentSalesmanMapping();
        if ($ret == '') {
            $_SESSION['surSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            $_SESSION['surErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            $_SESSION['surErr'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Parent Code*, Salesman Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}


// Todo : End : Jatin : 2 Feb 2024 : Parent Salesman mapping

// Todo : Start : Jatin : 2 Feb 2024 : Import Parent master

if (isset($_POST['parent_leads_csv']) && $_POST['parent_leads_csv'] == 'yes') {
    $data = "Parent Name*,Address,Phone Number*,State*,District*,City*,Customer Type*,Contact name1*,Contact Number1*,Contact Designation1*,Contact name2*,Contact Number2*,Contact Designation2*,Added By*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"parent_import_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['parent_leads']) && $_POST['parent_leads'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadParentSalesman();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } elseif ($ret == 'fnot') {
            $_SESSION['surErr'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Parent Name*,Address,Phone Number*,State*,District*,City*,Customer Type*,Contact name1*,Contact Number1*,Contact Designation1*,Contact name2*,Contact Number2*,Contact Designation2*,Added By*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }

}
// Todo : End : Jatin : 2 Feb 2024 : Import Parent master


// Todo : Start : Jatin : 13 Feb 2024 : Import Project master

if (isset($_POST['project_leads_csv']) && $_POST['project_leads_csv'] == 'yes') {
    $data = "Project Name*,Address*,Phone Number*,State*,District*,City*,Parent Code,Contact name*,Contact Number*,Contact Designation*,Distributor Code*,Remarks,Assign To (Salesman Code)*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"project_import_sheet.csv\"");
    echo $data;
    die;
}

if (isset($_POST['project_leads']) && $_POST['project_leads'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadProjectMaster();
//        echo "<pre>";print_r($ret);die;
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } elseif ($ret == 'fnot') {
            $_SESSION['surErr'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Project Name*,Address*,Phone Number*,State*,District*,City*,Parent Code,Contact name*,Contact Number*,Contact Designation*,Distributor Code*,Remarks,Assign To (Salesman Code)*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }

}

// Todo : End : Jatin : 13 Feb 2024 : Import Project master

// Todo : Start : Jatin : 5 March 2024 : Import Item Size Master

if (isset($_POST['item_size_master_csv']) && $_POST['item_size_master_csv'] == 'yes') {
    $data = "Item Size Code*,Item Size Name*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Item_size_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_item_size_master_csv']) && $_POST['import_item_size_master_csv'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {

        $ret = $_objItem->uploadItemSizeFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $_SESSION['surErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            $_SESSION['surErr'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Item Size Code*,Item Size Name*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}

// Todo : End : Jatin : 5 March 2024 : Import Item Size Master

// Todo : Start : Jatin : 7 March 2024 : Import Item color Master


if (isset($_POST['item_color_csv']) && $_POST['item_color_csv'] == 'yes') {
    $data = "Color Code*,Color Name*,RGB Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Item_color_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_item_color_csv']) && $_POST['import_item_color_csv'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {

        $ret = $_objItem->uploadColorSizeFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $_SESSION['surErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            $_SESSION['surErr'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Color Code*,Color Name*,RGB Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}

// Todo : End : Jatin : 7 March 2024 : Import Item color Master

// Todo : Start : Jatin : 7 March 2024 : Import Item Size Color Mapping

if (isset($_POST['item_color_size_mapping_csv']) && $_POST['item_color_size_mapping_csv'] == 'yes') {
    $data = "Item Code*,Color Code*,Size Code*,Price*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Item_color_size_mapping_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_item_color_size_mapping_csv']) && $_POST['import_item_color_size_mapping_csv'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {

        $ret = $_objItem->uploadColorSizeMappingFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $_SESSION['surErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            $_SESSION['surErr'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Item Code*,Color Code*,Size Code*,Price*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}

// Todo : End : Jatin : 7 March 2024 : Import Item Size Color Mapping

/************************************* CSV For Survey Feedback ***************************************/
if (isset($_POST['survey_feedback_import_csv']) && $_POST['survey_feedback_import_csv'] == 'yes') {
    $data = "Survey Name*,State*,Retailer Type*,Distributor Type,From date(YYYY-mm-dd)*,To date(YYYY-mm-dd)*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"survey_feedback_sheet.csv\"");
    echo $data;
    die;
}

if (isset($_POST['survey_feedback_import']) && $_POST['survey_feedback_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadSurveyFeedbackFile();
        //echo $ret; die;
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } else if ($ret == 'no') {
            $error1 = "Empty file";
        } else if ($ret == 'fnot') {
            $error1 = "File format not matched.";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Survey Name*,State*,Retailer Type*,Distributor Type,From date(YYYY-mm-dd)*,To date(YYYY-mm-dd)*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
if (isset($_POST['survey_feedback_questions_import_csv']) && $_POST['survey_feedback_questions_import_csv'] == 'yes') {
    $data = "Survey Code*,Question Number*,Question Text*,Is Que. Mandatory,Group Answer Type*,Answer Type*,Label*,Is Answer Type Mandatory,Keyboard Input Type(A/N),Options('|' separated)\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"survey_feedback_questions_sheet.csv\"");
    echo $data;
    die;
}

if (isset($_POST['survey_feedback_questions_import']) && $_POST['survey_feedback_questions_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadSurveyFeedbackQuestionFile();

        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else if ($ret == 'fnot') {
            $error1 = "File format not matched.";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Survey Code*,Question Number*,Question Text*,Is Que. Mandatory,Group Answer Type*,Answer Type*,Label*,Is Answer Type Mandatory,Keyboard Input Type(A/N),Options('|' separated)\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}

// Todo Start : Jatin : 29 April 2024 : Import stockist to distributor

if (isset($_POST['stockist_mapp_dist_csv']) && $_POST['stockist_mapp_dist_csv'] == 'yes') {
    $data = "" . $AliaseUsers['stockist'] . " Code*," . $AliaseUsers['distributor'] . " Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"dist_stk_mapping.csv\"");
    echo $data;
    die;
}

if (isset($_POST['stockict_mapp_dist']) && $_POST['stockict_mapp_dist'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDistributorStockistMapping();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else if ($ret == 'fnot') {
            $error1 = "File format not matched.";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['stockist'] . " Code*," . $AliaseUsers['distributor'] . " Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}

// Todo End : Jatin : 29 April 2024 : Import stockist to distributor

// Todo Start : sudhanshu 10 may 2024 : Import retailer address

if (isset($_POST['retailer_import_address_csv']) && $_POST['retailer_import_address_csv'] == 'yes') {
    $data = "" . $AliaseUsers['retailer'] . " Code*, Address*,Zipcode\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"retailer_address.csv\"");
    echo $data;
    die;
}


if (isset($_POST['retailer_import_address']) && $_POST['retailer_import_address'] == 'yes') {
    // echo "hii";die;
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerAddress();
        if ($ret == '') {
            // $msg = "File has been successfully imported.";
            $_SESSION['gradeSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            //  $error1 = "Empty file";
            $_SESSION['gradeErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            //$error1 = "File format not match.";
            $_SESSION['gradeErr'] = "File format not match.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['retailer'] . " Code*,Address*,Zipcode \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}


// Todo End : sudhanshu 10 may 2024 : Import retailer address

// Todo Start : sudhanshu 14 may 2024 : Import distributor address

if (isset($_POST['distributor_import_address_csv']) && $_POST['distributor_import_address_csv'] == 'yes') {
    $data = "" . $AliaseUsers['distributor'] . " Code*, Address*,Zipcode\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"distributor_address.csv\"");
    echo $data;
    die;
}


if (isset($_POST['distributor_import_address']) && $_POST['distributor_import_address'] == 'yes') {
    // echo "hii";die;
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDistributorAddress();
        if ($ret == '') {
            // $msg = "File has been successfully imported.";
            $_SESSION['gradeSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            //  $error1 = "Empty file";
            $_SESSION['gradeErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            //$error1 = "File format not match.";
            $_SESSION['gradeErr'] = "File format not match.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['distributor'] . " Code*,Address*,Zipcode \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}

if (isset($_POST['stockist_import_address_csv']) && $_POST['stockist_import_address_csv'] == 'yes') {
    $data = "" . $AliaseUsers['stockist'] . " Code*, Address*,Zipcode\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"stockist_address.csv\"");
    echo $data;
    die;
}


if (isset($_POST['stockist_import_address']) && $_POST['stockist_import_address'] == 'yes') {
    // echo "hii";die;
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadStockistAddress();
        if ($ret == '') {
            // $msg = "File has been successfully imported.";
            $_SESSION['gradeSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            //  $error1 = "Empty file";
            $_SESSION['gradeErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            //$error1 = "File format not match.";
            $_SESSION['gradeErr'] = "File format not match.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import)," . $AliaseUsers['stockist'] . " Code*,Address*,Zipcode \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
// Todo End : sudhanshu 14 may 2024 : Import distributor address
//Todo Start: Sudhanshu: 08 july 2024 : import CSV For vehicle type
if (isset($_REQUEST['vehicle_type_import_csv']) && $_REQUEST['vehicle_type_import_csv'] == 'yes') {
    $data = "Vehicle Type*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"vehicle_type_sheet.csv\"");
    echo $data;
    die;
}
//Todo Start: Sudhanshu: 08 july 2024 : import CSV For vehicle type
if (isset($_POST['vehicle_type_import']) && $_POST['vehicle_type_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadVehicleType();
        if ($ret == '') {

            $_SESSION['gradeSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {

            $_SESSION['gradeErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {

            $_SESSION['gradeErr'] = "File format not match.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        }  else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Vehicle Type* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo Start: Sudhanshu: 08 july 2024 : import CSV For vehicle type

//Todo Start: Sudhanshu: 09 july 2024 : import CSV For vehicle type designation mapping
if (isset($_REQUEST['import_vehicle_type_designation_mapping_csv']) && $_REQUEST['import_vehicle_type_designation_mapping_csv'] == 'yes') {
    $data = "Designation*,Vehicle Type*,Per KM Cost*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"vehicle_type_designation_mapping_sheet.csv\"");
    echo $data;
    die;
}

//Todo Start: Sudhanshu: 09 july 2024 : import CSV For vehicle type designation mapping
if (isset($_POST['import_vehicle_type_designation_mapping']) && $_POST['import_vehicle_type_designation_mapping'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadVehicleTypeDesignationMapping();
        if ($ret == '') {

            $_SESSION['gradeSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {

            $_SESSION['gradeErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {

            $_SESSION['gradeErr'] = "File format not match.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        }  else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Designation*,Vehicle Type*,Per KM Cost* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo Start: Sudhanshu: 08 july 2024 : import CSV For vehicle type designation mapping

//Todo Start : sudhanshu 18 july 2024 import distributor fulfillment
if (isset($_POST['distributor_fulfillment_import_csv']) && $_POST['distributor_fulfillment_import_csv'] == 'yes') {
    $data = "Sr No,".$AliaseUsers['distributor']." Code,Item Code,Invoice No,Invoice Date,Invoiced Quantity,Price To Distributor(Per Piece),Invoice Amount,Invoice Type(Sales Invoice/Return Invoice)\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"distributor_fulfillment_sheet.csv\"");
    echo $data;
    die;
}

if (isset($_POST['distributor_fulfillment_import']) && $_POST['distributor_fulfillment_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDistributorFulfillment();
        if ($ret == '') {
            //$msg = "File has been successfully imported.";
            $_SESSION['gradeSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
            $_SESSION['gradeErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;
        } elseif ($ret == 'fnot') {

            $_SESSION['gradeErr'] = "File format not match.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
            die;
        } else {
            $error = implode(",", $ret);
        }

        if ($msg != '') {
            $sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete/Correct the row and Import Again),Sr No,".$AliaseUsers['distributor']." Code,Item Code,Invoice No,Invoice Date,Invoice Quantity,Price To Distributor(Per Piece),Invoice Amount,Invoice Type(Sales Invoice/Return Invoice)\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End : sudhanshu 18 july 2024 import distributor fulfillment

// Todo : Start : Jatin : 19 July 2024 : Import Item color Master Image

if (isset($_POST['item_color_image_csv']) && $_POST['item_color_image_csv'] == 'yes') {
    $data = "Item Code*,Color Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Item_color_image_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_item_color_image_csv']) && $_POST['import_item_color_image_csv'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {

        $ret = $_objItem->uploadColorImageSizeFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $_SESSION['surErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            $_SESSION['surErr'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Item Code*,Color Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}

// Todo : End : Jatin : 19 July 2024 : Import Item color Master Image

//Todo Start: Sudhanshu: 29 july 2024 : import retailer available stock
if (isset($_REQUEST['import_retailer_available_stock_csv']) && $_REQUEST['import_retailer_available_stock_csv'] == 'yes') {
    $data = "Date of Activity*,".$AliaseUsers['salesman']." Code*,". $AliaseUsers['retailer']." Code*,Item Code*, Quantity*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"retailer_available_stock_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_retailer_available_stock']) && $_POST['import_retailer_available_stock'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerAvailableStockFile();
        if ($ret == '') {

            $_SESSION['gradeSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {

            $_SESSION['gradeErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {

            $_SESSION['gradeErr'] = "File format not match.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        }  else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Date of Activity*,".$AliaseUsers['salesman']." Code*,".$AliaseUsers['retailer']." Code*,Item Code*,Quantity* \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End: Sudhanshu: 29 july 2024 : import retailer available stock

//Todo Start: Sudhanshu: 16 Aug 2024 : import delivery return load out import
if (isset($_REQUEST['import_delivery_return_load_out_csv']) && $_REQUEST['import_delivery_return_load_out_csv'] == 'yes') {
    $data = "".$AliaseUsers['salesman']." Code*,Item Code*,Quantity Added in Company Stock, Quantity Not Added in Company Stock\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"delivery_return_load_out_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['import_delivery_return_load_out']) && $_POST['import_delivery_return_load_out'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadDeliveryReturnLoadOutFile();
        if ($ret == '') {

            $_SESSION['gradeSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {

            $_SESSION['gradeErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {

            $_SESSION['gradeErr'] = "File format not match.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        }  else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),".$AliaseUsers['salesman']." Code*,Item Code*,Quantity Added in Company Stock,Quantity Not Added in Company Stock \n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo End: Sudhanshu: 16 Aug 2024 : import delivery return load out import

//Todo Start: Sudhanshu: 13 Oct 2023: import CSV For rsurvey and salesman mapping import
if (isset($_REQUEST['salesman_survey_saleman_mapping_csv']) && $_REQUEST['salesman_survey_saleman_mapping_csv'] == 'yes') {
    $data = "Survey Code*, Salesman Code*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"survey_salesman_mapping.csv\"");
    echo $data;
    die;
}
if (isset($_POST['salesman_survey_saleman_mapping_import']) && $_POST['salesman_survey_saleman_mapping_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadSalesmanSurveySalesmanMapping();

        if ($ret == '') {
            $_SESSION['surSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            $_SESSION['surErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            $_SESSION['surErr'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Survey Code*, Salesman Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}

if (isset($_POST['salesman_survey_saleman_mapping_import_update']) && $_POST['salesman_survey_saleman_mapping_import_update'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadSurveySalesmanMappingUpdate();
//        echo $ret;die;
        if ($ret == '') {
            $_SESSION['surSus'] = "File has been successfully imported.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'no') {
            $_SESSION['surErr'] = "Empty file";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } elseif ($ret == 'fnot') {
            $_SESSION['surErr'] = "File format not matched.";
            header('Location:' . basename($_SERVER['PHP_SELF']));
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Survey Code*, Salesman Code*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}
//Todo Start: Sudhanshu: 13 Oct 2023: import CSV For rsurvey and salesman mapping UPDATE

if (isset($_POST['salesman_survey_feedback_import_csv']) && $_POST['salesman_survey_feedback_import_csv'] == 'yes') {
    $data = "Survey Name*,Designation*,State*,Salesman Code*,From date(YYYY-mm-dd)*,To date(YYYY-mm-dd)*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"salesman_survey_feedback_sheet.csv\"");
    echo $data;
    die;
}

if (isset($_POST['salesman_survey_feedback_import']) && $_POST['salesman_survey_feedback_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadSalesmanSurveyFeedbackFile();
        //echo $ret; die;
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } else if ($ret == 'no') {
            $error1 = "Empty file";
        } else if ($ret == 'fnot') {
            $error1 = "File format not matched.";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Survey Name*,State*,Retailer Type*,Distributor Type,From date(YYYY-mm-dd)*,To date(YYYY-mm-dd)*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}

if (isset($_POST['survey_feedback_questions_import_csv']) && $_POST['survey_feedback_questions_import_csv'] == 'yes') {
    $data = "Survey Code*,Question Number*,Question Text*,Is Que. Mandatory,Group Answer Type*,Answer Type*,Label*,Is Answer Type Mandatory,Keyboard Input Type(A/N),Options('|' separated)\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"survey_feedback_questions_sheet.csv\"");
    echo $data;
    die;
}

if (isset($_POST['salesman_survey_feedback_questions_import']) && $_POST['salesman_survey_feedback_questions_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadSalesmanSurveyFeedbackQuestionFile();

        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else if ($ret == 'fnot') {
            $error1 = "File format not matched.";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Survey Code*,Question Number*,Question Text*,Is Que. Mandatory,Group Answer Type*,Answer Type*,Label*,Is Answer Type Mandatory,Keyboard Input Type(A/N),Options\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}


/************************************* CSV For Sub Category ***************************************/

if (isset($_POST['subcategory_import_csv']) && $_POST['subcategory_import_csv'] == 'yes') {
    $data = "Sub Category Name*,Sub Category Code\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"subcategory_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['subcategory_import']) && $_POST['subcategory_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadSubCategoryFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Sub Category Name*,Sub Category Code\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}

if (isset($_POST['state_and_item_ranking_mapping_csv']) && $_POST['state_and_item_ranking_mapping_csv'] == 'yes') {
   
    $data = "Item Code*,State Code*,Item Rank Name*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"state_and_item_ranking_mapping_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['state_and_item_ranking_mapping']) && $_POST['state_and_item_ranking_mapping'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadStateItemRankMappingFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'updated') {
            $msg = "Item Rank Name is Updated";
        }elseif ($ret == 'no') {
            $error1 = "Empty file";
        } elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Item Code*,State Code*,Item Rank Name*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}

if (isset($_POST['item_ranking_import_csv']) && $_POST['item_ranking_import_csv'] == 'yes') {
   
    $data = "Rank Name*,Rank Order*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"item_ranking_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['item_ranking_import']) && $_POST['item_ranking_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadItemRankingListFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Rank Name*,Rank Order*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}


// Rohit code : Start : 18-feb-2025

if (isset($_POST['ret_channel_item_price_import_csv']) && $_POST['ret_channel_item_price_import_csv'] == 'yes') {
    $data = "Item Code*," . $AliaseUsers['retailer'] . " Channel*,Price*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Retailer_Channel_wise_Price_Sheet.csv\"");
    echo $data;
    die;
}


if (isset($_POST['ret_channel_item_price_import']) && $_POST['ret_channel_item_price_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadRetailerChannelItemPriceFile();

        if ($ret == '') {
            $msg = "File has been successfully imported.";
        }elseif ($ret == 'update') {
            $msg = "Price has been updated successfully.";
        }elseif ($ret == 'no') {
            $error1 = "Empty file";
        } elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Item Code*," . $AliaseUsers['retailer'] . " Channel*,Price*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}

// Rohit code : End : 18-feb-2025




/// import Competitor Master 


if (isset($_POST['competitor_master_import_csv']) && $_POST['competitor_master_import_csv'] == 'yes') {
   
    $data = "Competitor Name*,Competitor Code,Contact Person,Address,Contact No.,Email Id\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"competitor_master_sheet.csv\"");
    echo $data;
    die;
}

if(isset($_POST['competitor_master_import']) && $_POST['competitor_master_import']=='yes')
{
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {

       
        $ret = $_objItem->importCompetetorMasterCsv();


        if ($ret == "") {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }

        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
       
            $data = "Row Number(Please Delete The Row When Import),Competitor Name,Competitor Code,Contact Person,Address,Contact No.,Email Id\n ".$ret;
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}



// Import for Competitor Item master : Domar : 20-nov-2024 : start

if (isset($_POST['competitor_item_import_csv']) && $_POST['competitor_item_import_csv'] == 'yes') {
   
    $data = "Competitor Item Code,Competitor Item Name*,Competitor Brand Name*,Item Price\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"competitor_item_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['competitor_item_import']) && $_POST['competitor_item_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadCompetitorItemListFile();
        if ($ret == '') {
            $msg = "File has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        } elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Competitor Item Code,Competitor Item Name*,Competitor Brand Name*,Item Price\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}

// Import for Competitor Item master : Domar : 20-nov-2024 : End




// Import for Secondary Target : Domar : 13-mar-2025 : Category 

if (isset($_POST['target_category_import_csv']) && $_POST['target_category_import_csv'] == 'yes') {
    $data = "Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*,Target Criteria*," . $AliaseUsers['salesman'] . " Code*,Category Name*,Target Value*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Secondary_Target_category_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['target_category_csv_import']) && $_POST['target_category_csv_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadTargetCategoryFile();
        if ($ret == '') {
            $msg = "Targets has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        }elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*,Target Criteria*," . $AliaseUsers['salesman'] . " Code*,Category Name*,Target Value*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}



// Import for Secondary Target : Domar : 13-mar-2025 : Item  

if (isset($_POST['target_item_import_csv']) && $_POST['target_item_import_csv'] == 'yes') {
    $data = "Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*,Target Criteria*," . $AliaseUsers['salesman'] . " Code*,Item Code*,Target Value*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Secondary_Target_item_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['target_item_csv_import']) && $_POST['target_item_csv_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadTargetItemFile();
        if ($ret == '') {
            $msg = "Targets has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        }elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*,Target Criteria*," . $AliaseUsers['salesman'] . " Code*,Item Code*,Target Value*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}



// Import for Secondary Target : Domar : 13-mar-2025 : Number Of Order

if (isset($_POST['target_number_of_order_import_csv']) && $_POST['target_number_of_order_import_csv'] == 'yes') {
    $data = "Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target Value*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Secondary_Target_NumberOfOrder_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['target_number_of_order_csv_import']) && $_POST['target_number_of_order_csv_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadTargetNumberOfOrderFile();
        if ($ret == '') {
            $msg = "Targets has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        }elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Target Description*,Start Date(mm-dd-yyyy),End Date(mm-dd-yyyy),Target Value*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}






/////



// Import for Secondary Target : Domar : 13-mar-2025 : Number of retailer to visit Target

if (isset($_POST['target_numberOfVisit_import_csv']) && $_POST['target_numberOfVisit_import_csv'] == 'yes') {
    $data = "Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*," . $AliaseUsers['salesman'] . " Code*,No. of Retailer to Visit*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Secondary_Target_numberOfVisit_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['target_numberOfVisit_csv_import']) && $_POST['target_numberOfVisit_csv_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadTargetNoRetaileToVisistFile();
        if ($ret == '') {
            $msg = "Targets has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        }elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*," . $AliaseUsers['salesman'] . " Code*,No. of Retailer to Visit*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}



// Import for Secondary Target : Domar : 13-mar-2025 : Number of retailer to Add Target

if (isset($_POST['target_numberOfAdd_import_csv']) && $_POST['target_numberOfAdd_import_csv'] == 'yes') {
    $data = "Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For* ,". $AliaseUsers['salesman'] . " Code*,No. of Retailer to Add*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Secondary_Target_numberOfAdd_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['target_numberOfAdd_csv_import']) && $_POST['target_numberOfAdd_csv_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadTargetNoRetaileToAddFile();
        if ($ret == '') {
            $msg = "Targets has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        }elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*," . $AliaseUsers['salesman'] . " Code*,No. of Retailer to Add*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}



// Import for Secondary Target : Domar : 13-mar-2025 : Total Calls

if (isset($_POST['target_totalCalls_import_csv']) && $_POST['target_totalCalls_import_csv'] == 'yes') {
    $data = "Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target Value*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Secondary_Target_totalCalls_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['target_totalCalls_csv_import']) && $_POST['target_totalCalls_csv_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadTargetTotalCallsFile();
        if ($ret == '') {
            $msg = "Targets has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        }elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target Value*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}




/////



// Import for Secondary Target : Domar : 13-mar-2025 : Total Order Amount Target

if (isset($_POST['target_totalOrdAmt_import_csv']) && $_POST['target_totalOrdAmt_import_csv'] == 'yes') {
    $data = "Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*," . $AliaseUsers['salesman'] . " Code*,Target Value*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Secondary_Target_totalOrdAmt_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['target_totalOrdAmt_csv_import']) && $_POST['target_totalOrdAmt_csv_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadTargetTotalOrderAmountFile();
        if ($ret == '') {
            $msg = "Targets has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        }elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*," . $AliaseUsers['salesman'] . " Code*,Target Value*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}



// Import for Secondary Target : Domar : 13-mar-2025 : Brand

if (isset($_POST['target_brand_import_csv']) && $_POST['target_brand_import_csv'] == 'yes') {
    $data = "Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*,Target Criteria*," . $AliaseUsers['salesman'] . " Code*,Brand Name*,Target Value*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Secondary_Target_brand_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['target_brand_csv_import']) && $_POST['target_brand_csv_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadTargetBrandFile();
        if ($ret == '') {
            $msg = "Targets has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        }elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*,Target Criteria*," . $AliaseUsers['salesman'] . " Code*,Brand Name*,Target Value*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}



// Import for Secondary Target : Domar : 13-mar-2025 : Payment Collection Target

if (isset($_POST['target_payment_collection_import_csv']) && $_POST['target_payment_collection_import_csv'] == 'yes') {
    $data = "Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*," . $AliaseUsers['salesman'] . " Code*,Target Value*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Secondary_payment_collection_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['target_payment_collection_csv_import']) && $_POST['target_payment_collection_csv_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadTargetPaymentCollectionFile();
        if ($ret == '') {
            $msg = "Targets has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        }elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*," . $AliaseUsers['salesman'] . " Code*,Target Value*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}


// Import for Secondary Target : Domar : 17-mar-2025 : Sub Category 

if (isset($_POST['target_subcategory_import_csv']) && $_POST['target_subcategory_import_csv'] == 'yes') {
    $data = "Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*,Target Criteria*," . $AliaseUsers['salesman'] . " Code*,Sub-Category Name*,Target Value*\n";
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"Secondary_Target_subcategory_sheet.csv\"");
    echo $data;
    die;
}
if (isset($_POST['target_subcategory_csv_import']) && $_POST['target_subcategory_csv_import'] == 'yes') {
    if (isset($_FILES['fileToUpload']['tmp_name']) && $_FILES['fileToUpload']['tmp_name'] != "") {
        $ret = $_objItem->uploadTargetSubCategoryFile();
        if ($ret == '') {
            $msg = "Targets has been successfully imported.";
        } elseif ($ret == 'no') {
            $error1 = "Empty file";
        }elseif ($ret == 'fnot') {
            $error1 = "File Format Not Matched .";
        } else {
            $error = implode(",", $ret);
        }
        if ($msg != '') {
            $cat_sus = $msg;
        } elseif ($error1 != '') {
            $cat_err = $error1;
        } else {
            $data = "Row Number(Please Delete The Row When Import),Target Description*,Start Date(dd-mm-yyyy),End Date(dd-mm-yyyy),Target For*,Target Criteria*," . $AliaseUsers['salesman'] . " Code*,Sub-Category Name*,Target Value*\n";
            $data .= "$error \n";
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"error.csv\"");
            echo $data;
            die;
        }
    }
}





?>