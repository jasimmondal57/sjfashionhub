import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';

class NotificationService {
  final _messaging = FirebaseMessaging.instance;
  final _local  = FlutterLocalNotificationsPlugin();

  Future<void> init() async {
    await _messaging.requestPermission();
    final token = await _messaging.getToken();
    print('FCM token: $token');

    const androidInit = AndroidInitializationSettings('@mipmap/ic_launcher');
    const initSettings = InitializationSettings(android: androidInit);
    await _local.initialize(initSettings);

    FirebaseMessaging.onMessage.listen((msg) {
      _show(msg.notification?.title, msg.notification?.body);
    });
  }

  void _show(String? t, String? b) {
    const androidDetails = AndroidNotificationDetails(
        'high_importance','Notifications',
        importance: Importance.max, priority: Priority.high);
    _local.show(0, t, b, const NotificationDetails(android: androidDetails));
  }
}
