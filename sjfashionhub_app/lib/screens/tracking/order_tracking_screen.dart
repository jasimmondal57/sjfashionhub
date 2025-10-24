import 'package:flutter/material.dart';
import '../../services/shiprocket_service.dart';

class OrderTrackingScreen extends StatefulWidget {
  final String awb;
  const OrderTrackingScreen({super.key, required this.awb});

  @override
  State<OrderTrackingScreen> createState() => _OrderTrackingScreenState();
}

class _OrderTrackingScreenState extends State<OrderTrackingScreen> {
  bool loading = true;
  String? error;
  Map<String, dynamic>? trackingData;

  @override
  void initState() {
    super.initState();
    _loadTracking();
  }

  Future<void> _loadTracking() async {
    try {
      final data = await ShiprocketService.track(widget.awb);
      setState(() {
        trackingData = data['tracking_data'];
        loading = false;
      });
    } catch (e) {
      setState(() {
        error = "Tracking failed: ${e.toString()}";
        loading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    if (loading) {
      return const Scaffold(
        body: Center(child: CircularProgressIndicator()),
      );
    }
    if (error != null) {
      return Scaffold(
        body: Center(child: Text(error!)),
      );
    }
    final activities = trackingData!['shipment_track_activities'] as List<dynamic>;
    return Scaffold(
      appBar: AppBar(title: const Text("Track Order")),
      body: ListView.builder(
        itemCount: activities.length,
        itemBuilder: (_, i) {
          final step = activities[i];
          return ListTile(
            leading: const Icon(Icons.local_shipping),
            title: Text(step['activity']),
            subtitle: Text(step['date']),
          );
        },
      ),
    );
  }
}
