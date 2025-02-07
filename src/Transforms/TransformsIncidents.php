<?php

namespace TestMonitor\TOPdesk\Transforms;

use TestMonitor\TOPdesk\Validator;
use TestMonitor\TOPdesk\Resources\Incident;

trait TransformsIncidents
{
    /**
     * @param \TestMonitor\TOPdesk\Resources\Incident $incident
     * @return array
     */
    protected function toTopDeskIncident(Incident $incident): array
    {
        return array_filter([
            'caller' => array_filter([
                'branch' => array_filter([
                    'id' => $incident->branch,
                ]),
                'dynamicName' => $incident->callerName,
                'email' => $incident->callerEmail,
            ]),
            'briefDescription' => $incident->briefDescription,
            'externalNumber' => $incident->number,
            'request' => $incident->request,
        ]);
    }

    /**
     * @param array $incident
     * @return \TestMonitor\TOPdesk\Resources\Incident
     */
    protected function fromTopDeskIncident(array $incident): Incident
    {
        Validator::keyExists($incident, 'id');

        return new Incident([
            'callerName' => $incident['caller']['dynamicName'] ?? '',
            'callerEmail' => $incident['caller']['email'] ?? '',
            'status' => $incident['status'] ?? '',
            'number' => $incident['externalNumber'] ?? '',
            'request' => $incident['request'] ?? '',
            'briefDescription' => $incident['briefDescription'] ?? '',
            'id' => $incident['id'],
            'branch' => $incident['branch']['id'] ?? '',
        ]);
    }
}
