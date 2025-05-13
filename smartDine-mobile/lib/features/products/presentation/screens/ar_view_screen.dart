import 'dart:async';
import 'package:flutter/material.dart';
import 'package:ar_flutter_plugin_2/ar_flutter_plugin.dart';
import 'package:ar_flutter_plugin_2/managers/ar_session_manager.dart';
import 'package:ar_flutter_plugin_2/managers/ar_object_manager.dart';
import 'package:ar_flutter_plugin_2/managers/ar_anchor_manager.dart';
import 'package:ar_flutter_plugin_2/managers/ar_location_manager.dart';
import 'package:ar_flutter_plugin_2/models/ar_node.dart';
import 'package:ar_flutter_plugin_2/datatypes/node_types.dart';
import 'package:vector_math/vector_math_64.dart' as vm;

class ARViewScreen extends StatefulWidget {
  final String modelUrl;
  const ARViewScreen({Key? key, required this.modelUrl}) : super(key: key);

  @override
  State<ARViewScreen> createState() => _ARViewScreenState();
}

class _ARViewScreenState extends State<ARViewScreen> {
  ARSessionManager? _session;
  ARObjectManager? _objects;
  ARNode? _node;
  Timer? _ticker;

  @override
  void dispose() {
    _ticker?.cancel();
    _session?.dispose(); // Ensure the AR session is properly disposed
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('AR Preview')),
      body: ARView(onARViewCreated: _onARViewCreated),
    );
  }

  Future<void> _onARViewCreated(
    ARSessionManager session,
    ARObjectManager objects,
    ARAnchorManager anchor,
    ARLocationManager loc,
  ) async {
    _session = session;
    _objects = objects;

    // Initialize session settings
    await _session!.onInitialize(
      showFeaturePoints: false,
      showPlanes: false,
      customPlaneTexturePath: null,
      showWorldOrigin: false,
      handleTaps: false,
      showAnimatedGuide: false, // Add this line to hide the hand animation
    );
    await _objects!.onInitialize();

    // Place your model 1m in front initially
    final node = ARNode(
      type: NodeType.webGLB,
      uri: widget.modelUrl,
      scale: vm.Vector3(0.5, 0.5, 0.5),
      position: vm.Vector3(0, 0, -1), // Initial position in world space
    );
    final added = await _objects!.addNode(node);
    if (added == true) {
      _node = node;
      _startFollowingCamera();
    }
  }

  void _startFollowingCamera() {
    // Every 100ms, reposition the node to be in front of the camera
    _ticker = Timer.periodic(const Duration(milliseconds: 100), (_) async {
      if (!mounted || _session == null || _node == null) {
        // Added !mounted check for safety in async operations
        return;
      }

      final vm.Matrix4? cameraTransform = await _session!.getCameraPose();

      if (!mounted || cameraTransform == null) {
        // Check !mounted again after await, and ensure cameraTransform is not null
        return;
      }

      // Define a point 0.75 meters in front of the camera in camera's local coordinate space
      final vm.Vector3 pointInFrontOfCameraLocal = vm.Vector3(0, 0, -0.75);

      // Transform this point to world coordinate space
      final vm.Vector3 targetWorldPosition = cameraTransform.transform3(pointInFrontOfCameraLocal);

      if (!mounted) return; // Final check before updating node properties

      // Update the node's properties
      _node!.position = targetWorldPosition;
      // Maintain initial orientation and scale
      _node!.eulerAngles = vm.Vector3(0.0, 0.0, 0.0);
      _node!.scale = vm.Vector3(0.5, 0.5, 0.5);
    });
  }
}
