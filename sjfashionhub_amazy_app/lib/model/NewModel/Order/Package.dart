import 'package:sjfashionhub/model/NewModel/Order/DeliveryState.dart';
import 'package:sjfashionhub/model/NewModel/Order/GstTax.dart';
import 'package:sjfashionhub/model/NewModel/Order/OrderData.dart';
import 'package:sjfashionhub/model/NewModel/Order/OrderModelRefundReason.dart';
import 'package:sjfashionhub/model/NewModel/Order/OrderProductElement.dart';
import 'package:sjfashionhub/model/NewModel/Order/Process.dart';
import 'package:sjfashionhub/model/NewModel/Seller/SellerData.dart';
import 'package:sjfashionhub/utils/app_utilities.dart';

class Package {
  Package({
    this.id,
    this.orderId,
    this.sellerId,
    this.packageCode,
    this.numberOfProduct,
    this.shippingCost,
    this.shippingDate,
    this.shippingMethod,
    this.isCancelled,
    this.isReviewed,
    this.deliveryStatus,
    this.taxAmount,
    this.createdAt,
    this.updatedAt,
    this.deliveryStateName,
    this.totalGst,
    this.seller,
    this.deliveryStates,
    this.products,
    this.gstTaxes,
    this.processes,
    this.refundReasons,
    this.order,
  });

  dynamic id;
  dynamic orderId;
  dynamic sellerId;
  String? packageCode;
  dynamic numberOfProduct;
  dynamic shippingCost;
  String? shippingDate;
  dynamic shippingMethod;
  dynamic isCancelled;
  dynamic isReviewed;
  dynamic deliveryStatus;
  double? taxAmount;
  DateTime? createdAt;
  DateTime? updatedAt;
  String? deliveryStateName;
  double? totalGst;
  SellerData? seller;
  List<DeliveryState>? deliveryStates;
  List<OrderProductElement>? products;
  List<GstTax>? gstTaxes;
  List<Process>? processes;
  List<RefundReason>? refundReasons;
  OrderData? order;

  factory Package.fromJson(Map<String, dynamic> json) => Package(
        id: json["id"],
        orderId: json["order_id"],
        sellerId: json["seller_id"],
        packageCode: json["package_code"],
        numberOfProduct: json["number_of_product"],
        shippingCost: json["shipping_cost"],
        shippingDate: json["shipping_date"],
        shippingMethod: json["shipping_method"],
        isCancelled: json["is_cancelled"],
        isReviewed: json["is_reviewed"],
        deliveryStatus: json["delivery_status"],
        taxAmount: AppUtilities.convertToDouble(item: json["tax_amount"]),
    createdAt: AppUtilities.convertToDateTime(dateTime:json["created_at"]),
    updatedAt:AppUtilities.convertToDateTime(dateTime:json["updated_at"]),
        deliveryStateName: json["deliveryStateName"],
        totalGst: double.tryParse("${json["totalGST"]}"),
        seller: json["seller"] == null ? null : SellerData.fromJson(json["seller"]),
        deliveryStates: json["delivery_states"] == null ? null : List<DeliveryState>.from(json["delivery_states"].map((x) => DeliveryState.fromJson(x))),
        products: json["products"] == null ? null : List<OrderProductElement>.from(json["products"].map((x) => OrderProductElement.fromJson(x))),
        gstTaxes: json["gst_taxes"] == null ? null : List<GstTax>.from(json["gst_taxes"].map((x) => GstTax.fromJson(x))),
        processes: json["processes"] == null ? null : List<Process>.from(json["processes"].map((x) => Process.fromJson(x))),
        order: json["order"] == null ? null : OrderData.fromJson(json["order"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "order_id": orderId,
        "seller_id": sellerId,
        "package_code": packageCode,
        "number_of_product": numberOfProduct,
        "shipping_cost": shippingCost,
        "shipping_date": shippingDate,
        "shipping_method": shippingMethod,
        "is_cancelled": isCancelled,
        "is_reviewed": isReviewed,
        "delivery_status": deliveryStatus,
        "tax_amount": taxAmount,
        "created_at": createdAt?.toIso8601String(),
        "updated_at": updatedAt?.toIso8601String(),
        "deliveryStateName": deliveryStateName,
        "totalGST": totalGst,
        "seller": seller?.toJson(),
        "delivery_states": deliveryStates == null ? null :  List<dynamic>.from(deliveryStates!.map((x) => x.toJson())),
        "products": products == null ? null :  List<dynamic>.from(products!.map((x) => x.toJson())),
        "gst_taxes": gstTaxes == null ? null : List<dynamic>.from(gstTaxes!.map((x) => x.toJson())),
        "processes": processes == null ? null :  List<dynamic>.from(processes!.map((x) => x.toJson())),
        "order": order == null ? null : order!.toJson(),
      };
}
