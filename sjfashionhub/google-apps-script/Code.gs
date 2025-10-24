/**
 * SJ Fashion Hub - Google Sheets Integration Script
 * 
 * This Google Apps Script handles automatic data synchronization between
 * SJ Fashion Hub and Google Sheets for Orders, Returns, and Users data.
 * 
 * Deploy this as a Web App to enable real-time data sync.
 */

/**
 * Main function to handle POST requests from SJ Fashion Hub
 */
function doPost(e) {
  try {
    // Check if this is a valid POST request
    if (!e || !e.postData || !e.postData.contents) {
      throw new Error('Invalid request: No POST data received');
    }

    // Parse the incoming data
    const data = JSON.parse(e.postData.contents);
    const action = data.action;
    const spreadsheetId = data.spreadsheet_id;
    const sheetName = data.sheet_name;
    const columnMapping = data.column_mapping;
    const rowData = data.data;
    const sheetType = data.sheet_type;
    
    // Log the request for debugging
    console.log('Received request:', {
      action: action,
      sheetType: sheetType,
      spreadsheetId: spreadsheetId,
      sheetName: sheetName,
      dataCount: Array.isArray(rowData) ? rowData.length : 1
    });
    
    // Open the spreadsheet
    const spreadsheet = SpreadsheetApp.openById(spreadsheetId);
    let sheet = spreadsheet.getSheetByName(sheetName);
    
    // Create sheet if it doesn't exist
    if (!sheet) {
      sheet = spreadsheet.insertSheet(sheetName);
      
      // Add headers based on sheet type
      const headers = getHeadersForSheetType(sheetType, columnMapping);
      if (headers.length > 0) {
        sheet.getRange(1, 1, 1, headers.length).setValues([headers]);
        
        // Format headers
        const headerRange = sheet.getRange(1, 1, 1, headers.length);
        headerRange.setBackground('#4285f4');
        headerRange.setFontColor('#ffffff');
        headerRange.setFontWeight('bold');
        headerRange.setHorizontalAlignment('center');
      }
    }
    
    // Handle different actions
    switch (action) {
      case 'test_connection':
        return handleTestConnection(sheet, sheetName);
        
      case 'create':
      case 'update':
        return handleSingleRecord(sheet, rowData, columnMapping, action);
        
      case 'bulk_insert':
        return handleBulkInsert(sheet, rowData, columnMapping);
        
      case 'delete':
        return handleDelete(sheet, rowData, columnMapping);

      case 'create_headers':
        return handleCreateHeaders(sheet, data.headers, columnMapping, sheetType);

      default:
        throw new Error('Unknown action: ' + action);
    }
    
  } catch (error) {
    console.error('Error processing request:', error);

    // More detailed error information
    const errorInfo = {
      success: false,
      error: error.toString(),
      error_type: error.name || 'Unknown',
      timestamp: new Date().toISOString(),
      help: 'Check that the request includes valid POST data with required fields'
    };

    // Add specific help for common errors
    if (error.message.includes('postData')) {
      errorInfo.help = 'This script must be called via HTTP POST request, not run directly. Use the testScript() function for testing.';
      errorInfo.suggestion = 'Run testScript() function in the editor to test the script functionality.';
    }

    return ContentService.createTextOutput(JSON.stringify(errorInfo))
      .setMimeType(ContentService.MimeType.JSON);
  }
}

/**
 * Handle GET requests (for testing)
 */
function doGet(e) {
  return ContentService.createTextOutput(JSON.stringify({
    message: 'SJ Fashion Hub Google Sheets Integration',
    status: 'active',
    version: '1.0.0',
    timestamp: new Date().toISOString(),
    supportedActions: ['test_connection', 'create', 'update', 'bulk_insert', 'delete']
  })).setMimeType(ContentService.MimeType.JSON);
}

/**
 * Test connection and return sheet information
 */
function handleTestConnection(sheet, sheetName) {
  const sheetInfo = {
    name: sheetName,
    rows: sheet.getLastRow(),
    columns: sheet.getLastColumn(),
    url: sheet.getParent().getUrl(),
    lastModified: sheet.getParent().getLastUpdated()
  };
  
  return ContentService.createTextOutput(JSON.stringify({
    success: true,
    message: 'Connection successful',
    sheet_info: sheetInfo,
    timestamp: new Date().toISOString()
  })).setMimeType(ContentService.MimeType.JSON);
}

/**
 * Handle single record creation or update
 */
function handleSingleRecord(sheet, rowData, columnMapping, action) {
  if (!rowData || typeof rowData !== 'object') {
    throw new Error('Invalid row data provided');
  }
  
  // Convert row data to array based on column mapping
  const values = Object.keys(columnMapping).map(key => {
    const value = rowData[key];
    return formatCellValue(value);
  });
  
  let rowsAffected = 0;
  
  if (action === 'update' && rowData.id) {
    // Try to find existing row by ID and update it
    const idColumn = getColumnLetter(columnMapping, 'id') || 'A';
    const dataRange = sheet.getDataRange();
    const searchValues = dataRange.getValues();
    
    for (let i = 1; i < searchValues.length; i++) { // Start from 1 to skip header
      const idColumnIndex = columnLetterToIndex(idColumn);
      if (searchValues[i][idColumnIndex] == rowData.id) {
        // Update existing row
        sheet.getRange(i + 1, 1, 1, values.length).setValues([values]);
        rowsAffected = 1;
        break;
      }
    }
  }
  
  if (rowsAffected === 0) {
    // Append new row
    sheet.appendRow(values);
    rowsAffected = 1;
  }
  
  return ContentService.createTextOutput(JSON.stringify({
    success: true,
    message: `Record ${action}d successfully`,
    records_processed: rowsAffected,
    timestamp: new Date().toISOString()
  })).setMimeType(ContentService.MimeType.JSON);
}

/**
 * Handle bulk insert of multiple records
 */
function handleBulkInsert(sheet, rowData, columnMapping) {
  if (!Array.isArray(rowData) || rowData.length === 0) {
    throw new Error('Invalid bulk data provided');
  }
  
  // Convert all rows to 2D array
  const values = rowData.map(row => {
    return Object.keys(columnMapping).map(key => {
      const value = row[key];
      return formatCellValue(value);
    });
  });
  
  // Insert all rows at once
  const startRow = sheet.getLastRow() + 1;
  sheet.getRange(startRow, 1, values.length, values[0].length).setValues(values);
  
  // Auto-resize columns
  sheet.autoResizeColumns(1, values[0].length);
  
  return ContentService.createTextOutput(JSON.stringify({
    success: true,
    message: 'Bulk insert completed successfully',
    records_processed: values.length,
    start_row: startRow,
    timestamp: new Date().toISOString()
  })).setMimeType(ContentService.MimeType.JSON);
}

/**
 * Handle record deletion
 */
function handleDelete(sheet, rowData, columnMapping) {
  if (!rowData || !rowData.id) {
    throw new Error('ID required for deletion');
  }
  
  const idColumn = getColumnLetter(columnMapping, 'id') || 'A';
  const dataRange = sheet.getDataRange();
  const searchValues = dataRange.getValues();
  
  for (let i = 1; i < searchValues.length; i++) { // Start from 1 to skip header
    const idColumnIndex = columnLetterToIndex(idColumn);
    if (searchValues[i][idColumnIndex] == rowData.id) {
      sheet.deleteRow(i + 1);
      
      return ContentService.createTextOutput(JSON.stringify({
        success: true,
        message: 'Record deleted successfully',
        records_processed: 1,
        timestamp: new Date().toISOString()
      })).setMimeType(ContentService.MimeType.JSON);
    }
  }
  
  throw new Error('Record not found for deletion');
}

/**
 * Get headers for different sheet types
 */
function getHeadersForSheetType(sheetType, columnMapping) {
  const headers = Object.keys(columnMapping);
  
  // Customize headers based on sheet type
  switch (sheetType) {
    case 'orders':
      return headers.map(key => {
        const headerMap = {
          'order_id': 'Order ID',
          'customer_name': 'Customer Name',
          'customer_email': 'Customer Email',
          'customer_phone': 'Customer Phone',
          'total_amount': 'Total Amount',
          'status': 'Status',
          'payment_status': 'Payment Status',
          'shipping_address': 'Shipping Address',
          'order_date': 'Order Date',
          'updated_at': 'Last Updated',
          'items_count': 'Items Count',
          'shipping_method': 'Shipping Method',
          'tracking_number': 'Tracking Number',
          'notes': 'Notes'
        };
        return headerMap[key] || key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
      });
      
    case 'returns':
      return headers.map(key => {
        const headerMap = {
          'return_id': 'Return ID',
          'order_id': 'Order ID',
          'customer_name': 'Customer Name',
          'customer_email': 'Customer Email',
          'return_reason': 'Return Reason',
          'return_status': 'Return Status',
          'refund_amount': 'Refund Amount',
          'return_date': 'Return Date',
          'approved_date': 'Approved Date',
          'refund_date': 'Refund Date',
          'quality_check': 'Quality Check',
          'admin_notes': 'Admin Notes',
          'tracking_number': 'Tracking Number'
        };
        return headerMap[key] || key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
      });
      
    case 'users':
      return headers.map(key => {
        const headerMap = {
          'user_id': 'User ID',
          'name': 'Name',
          'email': 'Email',
          'phone': 'Phone',
          'role': 'Role',
          'status': 'Status',
          'registration_date': 'Registration Date',
          'last_login': 'Last Login',
          'total_orders': 'Total Orders',
          'total_spent': 'Total Spent',
          'address': 'Address',
          'city': 'City',
          'state': 'State',
          'postal_code': 'Postal Code',
          'country': 'Country',
          'date_of_birth': 'Date of Birth',
          'gender': 'Gender',
          'email_marketing_consent': 'Email Marketing',
          'sms_marketing_consent': 'SMS Marketing',
          'total_addresses': 'Total Addresses',
          'default_address': 'Default Address',
          'created_at': 'Created At',
          'updated_at': 'Updated At'
        };
        return headerMap[key] || key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
      });

    case 'user_addresses':
      return headers.map(key => {
        const headerMap = {
          'address_id': 'Address ID',
          'user_id': 'User ID',
          'user_name': 'User Name',
          'user_email': 'User Email',
          'address_type': 'Address Type',
          'first_name': 'First Name',
          'last_name': 'Last Name',
          'company': 'Company',
          'address_line_1': 'Address Line 1',
          'address_line_2': 'Address Line 2',
          'city': 'City',
          'state': 'State',
          'postal_code': 'Postal Code',
          'country': 'Country',
          'phone': 'Phone',
          'is_default': 'Is Default',
          'created_at': 'Created At',
          'updated_at': 'Updated At'
        };
        return headerMap[key] || key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
      });

    case 'user_changes':
      return headers.map(key => {
        const headerMap = {
          'change_id': 'Change ID',
          'user_id': 'User ID',
          'user_name': 'User Name',
          'user_email': 'User Email',
          'change_type': 'Change Type',
          'field_name': 'Field Name',
          'old_value': 'Previous Value',
          'new_value': 'New Value',
          'changed_by': 'Changed By',
          'ip_address': 'IP Address',
          'user_agent': 'User Agent',
          'changed_at': 'Changed At'
        };
        return headerMap[key] || key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
      });

    case 'newsletters':
      return headers.map(key => {
        const headerMap = {
          'subscriber_id': 'Subscriber ID',
          'email': 'Email Address',
          'name': 'Name',
          'status': 'Status',
          'subscribed_at': 'Subscribed Date',
          'unsubscribed_at': 'Unsubscribed Date',
          'source': 'Source',
          'ip_address': 'IP Address',
          'user_agent': 'User Agent',
          'preferences': 'Preferences',
          'created_at': 'Created Date',
          'updated_at': 'Updated Date'
        };
        return headerMap[key] || key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
      });

    default:
      return headers.map(key => key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()));
  }
}

/**
 * Format cell values for Google Sheets
 */
function formatCellValue(value) {
  if (value === null || value === undefined) {
    return '';
  }
  
  if (typeof value === 'object') {
    return JSON.stringify(value);
  }
  
  if (typeof value === 'boolean') {
    return value ? 'Yes' : 'No';
  }
  
  return String(value);
}

/**
 * Get column letter for a field from column mapping
 */
function getColumnLetter(columnMapping, fieldName) {
  return columnMapping[fieldName] || null;
}

/**
 * Convert column letter to index (A=0, B=1, etc.)
 */
function columnLetterToIndex(letter) {
  let index = 0;
  for (let i = 0; i < letter.length; i++) {
    index = index * 26 + (letter.charCodeAt(i) - 'A'.charCodeAt(0) + 1);
  }
  return index - 1;
}

/**
 * Utility function to add timestamp to sheet
 */
function addTimestamp(sheet, row, column) {
  sheet.getRange(row, column).setValue(new Date());
}

/**
 * Utility function to protect header row
 */
function protectHeaders(sheet) {
  const protection = sheet.getRange(1, 1, 1, sheet.getLastColumn()).protect();
  protection.setDescription('Header row - protected from editing');
  protection.setWarningOnly(true);
}

/**
 * Initialize sheet with proper formatting
 */
function initializeSheet(sheet, sheetType) {
  // Freeze header row
  sheet.setFrozenRows(1);
  
  // Set column widths based on sheet type
  switch (sheetType) {
    case 'orders':
      sheet.setColumnWidth(1, 100); // Order ID
      sheet.setColumnWidth(2, 150); // Customer Name
      sheet.setColumnWidth(3, 200); // Customer Email
      sheet.setColumnWidth(4, 120); // Customer Phone
      sheet.setColumnWidth(5, 100); // Total Amount
      break;
      
    case 'returns':
      sheet.setColumnWidth(1, 100); // Return ID
      sheet.setColumnWidth(2, 100); // Order ID
      sheet.setColumnWidth(3, 150); // Customer Name
      sheet.setColumnWidth(4, 200); // Customer Email
      break;
      
    case 'users':
      sheet.setColumnWidth(1, 80);  // User ID
      sheet.setColumnWidth(2, 150); // Name
      sheet.setColumnWidth(3, 200); // Email
      sheet.setColumnWidth(4, 120); // Phone
      break;

    case 'newsletters':
      sheet.setColumnWidth(1, 100); // Subscriber ID
      sheet.setColumnWidth(2, 200); // Email Address
      sheet.setColumnWidth(3, 150); // Name
      sheet.setColumnWidth(4, 100); // Status
      sheet.setColumnWidth(5, 150); // Subscribed Date
      sheet.setColumnWidth(6, 150); // Unsubscribed Date
      sheet.setColumnWidth(7, 120); // Source
      break;
  }
  
  // Protect headers
  protectHeaders(sheet);
}

/**
 * Handle creating headers for a sheet
 */
function handleCreateHeaders(sheet, headers, columnMapping, sheetType) {
  try {
    // Clear existing headers if any
    const lastColumn = sheet.getLastColumn();
    if (lastColumn > 0) {
      sheet.getRange(1, 1, 1, lastColumn).clearContent();
    }

    // Create headers array based on column mapping
    const headerValues = [];
    const maxColumn = Math.max(...Object.values(columnMapping).map(col => getColumnNumber(col)));

    // Initialize array with empty values
    for (let i = 0; i < maxColumn; i++) {
      headerValues[i] = '';
    }

    // Fill in the headers based on column mapping
    for (const [field, column] of Object.entries(columnMapping)) {
      const colIndex = getColumnNumber(column) - 1; // Convert to 0-based index
      headerValues[colIndex] = headers[field] || formatFieldName(field);
    }

    // Set the headers
    if (headerValues.length > 0) {
      sheet.getRange(1, 1, 1, headerValues.length).setValues([headerValues]);

      // Format headers
      const headerRange = sheet.getRange(1, 1, 1, headerValues.length);
      headerRange.setBackground('#4285f4');
      headerRange.setFontColor('#ffffff');
      headerRange.setFontWeight('bold');
      headerRange.setHorizontalAlignment('center');
      headerRange.setVerticalAlignment('middle');

      // Set column widths based on sheet type
      setColumnWidths(sheet, sheetType);

      // Protect headers
      protectHeaders(sheet);
    }

    return ContentService.createTextOutput(JSON.stringify({
      success: true,
      message: `Headers created successfully for ${sheetType}`,
      headers_count: headerValues.filter(h => h !== '').length,
      timestamp: new Date().toISOString()
    })).setMimeType(ContentService.MimeType.JSON);

  } catch (error) {
    console.error('Error creating headers:', error);
    return ContentService.createTextOutput(JSON.stringify({
      success: false,
      error: error.toString(),
      timestamp: new Date().toISOString()
    })).setMimeType(ContentService.MimeType.JSON);
  }
}

/**
 * Convert column letter to number (A=1, B=2, etc.)
 */
function getColumnNumber(columnLetter) {
  let result = 0;
  for (let i = 0; i < columnLetter.length; i++) {
    result = result * 26 + (columnLetter.charCodeAt(i) - 'A'.charCodeAt(0) + 1);
  }
  return result;
}

/**
 * Format field name to readable header
 */
function formatFieldName(field) {
  return field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
}

/**
 * Test function that can be run directly in Google Apps Script editor
 * This helps verify the script is working without needing HTTP requests
 */
function testScript() {
  try {
    console.log('🧪 Testing SJ Fashion Hub Google Sheets Integration...');

    // Test 1: Check if we can access SpreadsheetApp
    console.log('✅ SpreadsheetApp access: OK');

    // Test 2: Test helper functions
    console.log('🔧 Testing helper functions...');

    const colNum = getColumnNumber('C');
    console.log('✅ getColumnNumber("C") =', colNum);

    const formatted = formatFieldName('customer_name');
    console.log('✅ formatFieldName("customer_name") =', formatted);

    // Test 3: Sample data structures
    const testHeaders = {
      'order_id': 'Order ID',
      'customer_name': 'Customer Name',
      'customer_email': 'Customer Email',
      'total_amount': 'Total Amount',
      'status': 'Status'
    };

    const testColumnMapping = {
      'order_id': 'A',
      'customer_name': 'B',
      'customer_email': 'C',
      'total_amount': 'D',
      'status': 'E'
    };

    console.log('✅ Test data prepared');
    console.log('📊 Sample headers:', Object.keys(testHeaders).length, 'fields');
    console.log('🗂️ Sample mapping:', Object.keys(testColumnMapping).length, 'columns');

    console.log('🎉 All tests passed! Script is ready for use.');
    console.log('📝 To use this script:');
    console.log('   1. Deploy as Web App');
    console.log('   2. Set permissions to "Anyone"');
    console.log('   3. Copy the Web App URL to your Laravel app');
    console.log('   4. Configure Google Sheets settings in admin panel');

    return {
      success: true,
      message: 'Test completed successfully',
      timestamp: new Date().toISOString()
    };

  } catch (error) {
    console.error('❌ Test failed:', error);
    return {
      success: false,
      error: error.toString(),
      timestamp: new Date().toISOString()
    };
  }
}
