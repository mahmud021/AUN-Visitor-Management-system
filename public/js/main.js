window.addEventListener('DOMContentLoaded', async () => {
    try {
        // 1) Initialize the SDK
        const sdk = await ScanbotSDK.initialize({
            licenseKey: "",
            enginePath: "https://cdn.jsdelivr.net/npm/scanbot-web-sdk@7.1.0/bundle/bin/complete/"
        });
        console.log("✅ SDK initialized");

        // 2) Wire up the button
        const btn = document.getElementById('start-scan');
        btn.addEventListener('click', async () => {
            console.log("🔘 Button clicked – launching scanner");

            // 3) Configure & launch the scanner
            const config = new ScanbotSDK.UI.Config.BarcodeScannerScreenConfiguration({
                beepOnScan: true,
                multiScanEnabled: false,
            });
            const result = await ScanbotSDK.UI.createBarcodeScanner(config);

            // 4) Inspect & extract properly
            console.log("Scanner closed, result =", result);
            if (result?.items?.length) {
                result.items.forEach((item, i) => {
                    // Now grabbing from item.barcode
                    console.log(
                        `Code #${i+1}:`,
                        "text→", item.barcode.text,
                        "format→", item.barcode.format,
                        `(seen ${item.count} time${item.count > 1 ? 's' : ''})`
                    );
                });
            } else {
                console.log("No barcodes found – or user cancelled.");
            }
        });

    } catch (initErr) {
        console.error("❌ SDK init error:", initErr);
    }
});
