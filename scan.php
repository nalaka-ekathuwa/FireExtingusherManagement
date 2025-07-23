<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>NFC Scanner Demo</title>
</head>
<body>
  <h1>Scan NFC Tag</h1>
  <button id="scan-btn">Start Scan</button>
  <pre id="output"></pre>

  <script>
    const output = document.getElementById('output');
    document.getElementById('scan-btn').addEventListener('click', async () => {
      try {
        if ('NDEFReader' in window) {
          const ndef = new NDEFReader();
          await ndef.scan();
          output.textContent = 'Scan started - touch NFC tag...';

          ndef.onreading = event => {
            const { serialNumber, message } = event;
            let text = `NFC tag detected\nSerial: ${serialNumber}\n`;
            for (const record of message.records) {
              if (record.recordType === "text") {
                const decoder = new TextDecoder(record.encoding);
                text += `Text: ${decoder.decode(record.data)}\n`;
              } else {
                text += `Record type: ${record.recordType}\n`;
              }
            }
            output.textContent = text;

            // Here you can send serialNumber to your PHP backend via AJAX
          };

          ndef.onerror = () => {
            output.textContent = 'Error reading NFC tag.';
          };
        } else {
          output.textContent = 'Web NFC is not supported in this browser.';
        }
      } catch (error) {
        output.textContent = `Error: ${error}`;
      }
    });
  </script>
</body>
</html>
