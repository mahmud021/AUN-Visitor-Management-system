// Wrap in DOMContentLoaded so your elements exist
window.addEventListener('DOMContentLoaded', async () => {
    try {
        // 1) Initialize the SDK
        const sdk = await ScanbotSDK.initialize({
            licenseKey: "",
            enginePath: "https://cdn.jsdelivr.net/npm/scanbot-web-sdk@7.1.0/bundle/bin/complete/"
        });
        console.log("✅ SDK initialized", sdk);

        // 2) Wire up the button
        const btn = document.getElementById('start-scan');
        btn.addEventListener('click', async () => {
            console.log("🔘 Button clicked");

            try {
                // 3) Create the scanner UI (no containerId = full‑screen modal)
                const config = new ScanbotSDK.UI.Config.BarcodeScannerScreenConfiguration();
                const result = await ScanbotSDK.UI.createBarcodeScanner(config);

                // 4) Process the result
                if (result) {
                    console.log(`🎉 ${result.items.length} barcode(s) found`, result.items);
                    alert(`${result.items.length} barcode(s) found:\n` +
                        result.items.map((i, idx) => `${idx+1}. [${i.format}] ${i.text}`).join("\n")
                    );
                } else {
                    console.log("ℹ️ User cancelled scanning");
                }
            } catch (scanErr) {
                console.error("❌ Scanner error:", scanErr);
            }
        });
    } catch (initErr) {
        console.error("❌ SDK init error:", initErr);
    }
});
