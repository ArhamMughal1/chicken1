import Alpine from 'alpinejs';
import RateList from './components/RateList';
import ClientSales from './components/ClientSales';
import Purchases from './components/Purchases';
import SaleEntry from './components/SaleEntry';
import ClientRow from './components/ClientRow';
import SaleEdit from './components/SaleEdit';
import PurchaseEntry from './components/PurchaseEntry';
import ConfirmDelete from "./components/ConfirmDelete";
import WeightShortages from "./components/WeightShortages";

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('rateList', RateList);
    Alpine.data('clientSales', ClientSales);
    Alpine.data('purchases', Purchases);
    Alpine.data('saleEntry', SaleEntry);
    Alpine.data('clientRow', ClientRow);
    Alpine.data('saleEdit', SaleEdit);
    Alpine.data('purchaseEntry', PurchaseEntry);
    Alpine.data('confirmDelete', ConfirmDelete());
    Alpine.data('weightShortages', WeightShortages);
});

Alpine.start();

export default Alpine;
